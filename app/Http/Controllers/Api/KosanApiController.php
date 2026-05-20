<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kosan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KosanApiController extends Controller
{
    /**
     * GET /api/kosan
     * Daftar semua kosan aktif (publik).
     */
    public function index(Request $request)
    {
        $query = Kosan::with('fotoUtama')->where('status', 'aktif');

        // Filter opsional
        if ($request->filled('kota')) {
            $query->where('kota', 'like', '%' . $request->kota . '%');
        }
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }
        if ($request->filled('min_harga')) {
            $query->where('harga_per_bulan', '>=', $request->min_harga);
        }
        if ($request->filled('max_harga')) {
            $query->where('harga_per_bulan', '<=', $request->max_harga);
        }
        if ($request->filled('tersedia') && $request->tersedia == 1) {
            $query->where('kamar_tersedia', '>', 0);
        }

        $kosans = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'message' => 'Daftar kosan berhasil diambil',
            'data'    => $kosans,
        ]);
    }

    /**
     * GET /api/kosan/{id}
     * Detail satu kosan (publik).
     */
    public function show($id)
    {
        $kosan = Kosan::with(['pemilik:id,nama,no_telepon', 'fotoUtama', 'fotos', 'ulasans.user:id,nama'])
            ->find($id);

        if (! $kosan) {
            return response()->json([
                'success' => false,
                'message' => 'Kosan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail kosan berhasil diambil',
            'data'    => $kosan,
        ]);
    }

    /**
     * GET /api/my-kosan
     * Kosan milik pemilik yang sedang login.
     */
    public function myKosan()
    {
        if (Auth::user()->role !== 'pemilik') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya pemilik yang dapat mengakses fitur ini',
            ], 403);
        }

        $kosans = Kosan::with('fotoUtama')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar kosan saya berhasil diambil',
            'data'    => $kosans,
        ]);
    }

    /**
     * POST /api/kosan
     * Tambah kosan baru (hanya pemilik).
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'pemilik') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya pemilik yang dapat menambah kosan',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama_kosan'     => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'alamat'         => 'required|string',
            'kota'           => 'required|string|max:100',
            'harga_per_bulan'=> 'required|numeric|min:0',
            'jumlah_kamar'   => 'required|integer|min:1',
            'kamar_tersedia' => 'required|integer|min:0',
            'tipe'           => 'required|in:putra,putri,campur',
            'fasilitas'      => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $kosan = Kosan::create(array_merge($validator->validated(), [
            'user_id' => Auth::id(),
            'status'  => 'aktif',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Kosan berhasil ditambahkan',
            'data'    => $kosan,
        ], 201);
    }

    /**
     * PUT/PATCH /api/kosan/{id}
     * Update kosan (hanya pemilik kosan tersebut).
     */
    public function update(Request $request, $id)
    {
        $kosan = Kosan::find($id);

        if (! $kosan) {
            return response()->json([
                'success' => false,
                'message' => 'Kosan tidak ditemukan',
            ], 404);
        }

        if ($kosan->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengubah kosan ini',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama_kosan'     => 'sometimes|required|string|max:255',
            'deskripsi'      => 'sometimes|required|string',
            'alamat'         => 'sometimes|required|string',
            'kota'           => 'sometimes|required|string|max:100',
            'harga_per_bulan'=> 'sometimes|required|numeric|min:0',
            'jumlah_kamar'   => 'sometimes|required|integer|min:1',
            'kamar_tersedia' => 'sometimes|required|integer|min:0',
            'tipe'           => 'sometimes|required|in:putra,putri,campur',
            'fasilitas'      => 'nullable|array',
            'status'         => 'sometimes|in:aktif,nonaktif',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $kosan->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kosan berhasil diperbarui',
            'data'    => $kosan->fresh(),
        ]);
    }

    /**
     * DELETE /api/kosan/{id}
     * Hapus kosan (hanya pemilik kosan tersebut).
     */
    public function destroy($id)
    {
        $kosan = Kosan::find($id);

        if (! $kosan) {
            return response()->json([
                'success' => false,
                'message' => 'Kosan tidak ditemukan',
            ], 404);
        }

        if ($kosan->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk menghapus kosan ini',
            ], 403);
        }

        $kosan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kosan berhasil dihapus',
        ]);
    }
}