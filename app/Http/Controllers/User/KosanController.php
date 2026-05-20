<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kosan;
use Illuminate\Support\Facades\Auth;

class KosanController extends Controller
{
    public function show(Kosan $kosan)
    {
        $kosan->load(['fotos', 'pemilik', 'ulasans.user']);

        $ratingRata = $kosan->ulasans->avg('rating');
        $totalUlasan = $kosan->ulasans->count();

        // Cek apakah user sudah pernah memberi ulasan & bisa mengulas
        $sudahUlasan = false;
        $bisaUlas = false;
        if (Auth::check()) {
            $sudahUlasan = $kosan->ulasans->where('user_id', Auth::id())->isNotEmpty();
            $bisaUlas = $kosan->pemesanans()->where('user_id', Auth::id())->where('status', 'disetujui')->exists();
        }

        return view('user.show', compact('kosan', 'ratingRata', 'totalUlasan', 'sudahUlasan', 'bisaUlas'));
    }

    public function index()
    {
        $kosans = Kosan::where('status', 'aktif')
            ->where('kamar_tersedia', '>', 0)
            ->with(['fotoUtama', 'ulasans'])
            ->latest()->paginate(12);
        
        $fasilitasList = \App\Models\Fasilitas::orderBy('nama_fasilitas')->get();
        
        return view('user.home', compact('kosans', 'fasilitasList'));
    }

    public function search(Request $request)
    {
        $kosans = Kosan::where('status', 'aktif')
            ->where('kamar_tersedia', '>', 0)
            ->when($request->q, function($q) use ($request) {
                $q->where(function($query) use ($request) {
                    $query->where('nama_kosan', 'like', "%{$request->q}%")
                          ->orWhere('kota', 'like', "%{$request->q}%")
                          ->orWhere('alamat', 'like', "%{$request->q}%");
                });
            })
            ->when($request->kota, fn($q) => $q->where('kota', 'like', "%{$request->kota}%"))
            ->when($request->tipe, fn($q) => $q->where('tipe', $request->tipe))
            ->when($request->harga_max, fn($q) => $q->where('harga_per_bulan', '<=', $request->harga_max))
            ->when($request->fasilitas, fn($q) => $q->where(function($query) use ($request) {
                $fasilitas = is_array($request->fasilitas) ? $request->fasilitas : [$request->fasilitas];
                foreach ($fasilitas as $f) {
                    $query->whereJsonContains('fasilitas', $f);
                }
            }))
            ->with('fotoUtama')
            ->latest()
            ->paginate(12);
            
        $kosans->appends($request->all());
        $fasilitasList = \App\Models\Fasilitas::orderBy('nama_fasilitas')->get();

        return view('user.home', compact('kosans', 'fasilitasList'));
    }

    public function ulasan(Request $request, Kosan $kosan)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string'
        ]);

        $bisaUlas = $kosan->pemesanans()->where('user_id', Auth::id())->where('status', 'disetujui')->exists();
        if (!$bisaUlas) {
            return back()->with('error', 'Anda hanya bisa memberikan ulasan setelah pesanan Anda disetujui.');
        }

        if ($kosan->ulasans()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk kosan ini.');
        }

        $kosan->ulasans()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar
        ]);

        return back()->with('success', 'Ulasan berhasil ditambahkan!');
    }
}
