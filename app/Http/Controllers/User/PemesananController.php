<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kosan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    /**
     * Dashboard: daftar semua pemesanan user
     */
    public function dashboard()
    {
        $pemesanans = Pemesanan::where('user_id', Auth::id())
            ->with(['kosan.fotoUtama', 'kosan.pemilik'])
            ->latest()
            ->get();

        return view('user.dashboard', compact('pemesanans'));
    }

    /**
     * Daftar pemesanan user
     */
    public function index()
    {
        return redirect()->route('user.dashboard');
    }

    /**
     * Form buat pemesanan baru
     */
    public function create(Request $request)
    {
        $kosan = Kosan::with(['fotoUtama', 'pemilik'])->findOrFail($request->kosan_id);

        if ($kosan->kamar_tersedia <= 0) {
            return back()->with('error', 'Maaf, kamar sudah penuh.');
        }

        return view('user.pemesanan.create', compact('kosan'));
    }

    /**
     * Simpan pemesanan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kosan_id'      => 'required|exists:kosans,id',
            'tanggal_masuk' => 'required|date|after_or_equal:today',
            'durasi_bulan'  => 'required|integer|min:1|max:24',
            'catatan'       => 'nullable|string|max:500',
        ]);

        $kosan = Kosan::findOrFail($request->kosan_id);

        if ($kosan->kamar_tersedia <= 0) {
            return back()->with('error', 'Maaf, kamar sudah penuh.')->withInput();
        }

        $totalHarga = $kosan->harga_per_bulan * $request->durasi_bulan;

        $pemesanan = Pemesanan::create([
            'user_id'       => Auth::id(),
            'kosan_id'      => $kosan->id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'durasi_bulan'  => $request->durasi_bulan,
            'total_harga'   => $totalHarga,
            'status'        => 'pending',
            'catatan'       => $request->catatan,
        ]);

        return redirect()->route('user.pemesanan.show', $pemesanan)
            ->with('success', 'Pemesanan berhasil diajukan! Menunggu persetujuan pemilik kos.');
    }

    /**
     * Detail pemesanan
     */
    public function show(Pemesanan $pemesanan)
    {
        if ($pemesanan->user_id !== Auth::id()) {
            abort(403);
        }

        $pemesanan->load(['kosan.fotoUtama', 'kosan.pemilik']);

        return view('user.pemesanan.show', compact('pemesanan'));
    }

    /**
     * Batalkan pemesanan (hanya jika masih pending)
     */
    public function destroy(Pemesanan $pemesanan)
    {
        if ($pemesanan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($pemesanan->status !== 'pending') {
            return back()->with('error', 'Hanya pemesanan berstatus pending yang dapat dibatalkan.');
        }

        $pemesanan->update(['status' => 'dibatalkan']);

        return redirect()->route('user.dashboard')
            ->with('success', 'Pemesanan berhasil dibatalkan.');
    }
}
