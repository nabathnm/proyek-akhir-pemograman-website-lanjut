<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kosan;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UlasanApiController extends Controller
{
    /**
     * GET /api/kosan/{id}/ulasan
     * Daftar ulasan untuk satu kosan (publik).
     */
    public function index($id)
    {
        $kosan = Kosan::find($id);

        if (! $kosan) {
            return response()->json([
                'success' => false,
                'message' => 'Kosan tidak ditemukan',
            ], 404);
        }

        $ulasans = Ulasan::with('user:id,nama')
            ->where('kosan_id', $id)
            ->latest()
            ->get();

        $rataRating = $ulasans->avg('rating');

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil diambil',
            'data'    => [
                'rata_rating' => round($rataRating, 1),
                'total'       => $ulasans->count(),
                'ulasans'     => $ulasans,
            ],
        ]);
    }

    /**
     * POST /api/kosan/{id}/ulasan
     * Tambah ulasan untuk kosan (harus pernah menyewa dan disetujui).
     */
    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $kosan = Kosan::find($id);

        if (! $kosan) {
            return response()->json([
                'success' => false,
                'message' => 'Kosan tidak ditemukan',
            ], 404);
        }

        // Cek apakah user pernah menyewa kos ini dan disetujui
        $sudahSewa = Auth::user()
            ->pemesanans()
            ->where('kosan_id', $id)
            ->where('status', 'disetujui')
            ->exists();

        if (! $sudahSewa) {
            return response()->json([
                'success' => false,
                'message' => 'Anda hanya dapat mengulas kosan yang pernah Anda sewa dan disetujui',
            ], 403);
        }

        // Cek sudah pernah mengulas atau belum
        $sudahUlas = Ulasan::where('user_id', Auth::id())
            ->where('kosan_id', $id)
            ->exists();

        if ($sudahUlas) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan ulasan untuk kosan ini',
            ], 409);
        }

        $ulasan = Ulasan::create([
            'user_id'  => Auth::id(),
            'kosan_id' => $id,
            'rating'   => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil ditambahkan',
            'data'    => $ulasan->load('user:id,nama'),
        ], 201);
    }

    /**
     * DELETE /api/ulasan/{id}
     * Hapus ulasan milik user sendiri.
     */
    public function destroy($id)
    {
        $ulasan = Ulasan::where('user_id', Auth::id())->find($id);

        if (! $ulasan) {
            return response()->json([
                'success' => false,
                'message' => 'Ulasan tidak ditemukan atau bukan milik Anda',
            ], 404);
        }

        $ulasan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil dihapus',
        ]);
    }
}