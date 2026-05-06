<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Kos $kos)
    {
        return view('kamar.create', compact('kos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Kos $kos)
    {
        $request->validate([
            'nama_kamar' => 'required',
            'harga' => 'required|numeric',
            'fasilitas' => 'nullable',
        ]);

        $kos->kamar()->create([
            'nama_kamar' => $request->nama_kamar,
            'harga' => $request->harga,
            'fasilitas' => $request->fasilitas,
            'status' => Kamar::STATUS_KOSONG,
        ]);

        return redirect()->route('kos.show', $kos->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kos $kos, Kamar $kamar)
    {
        return view('kamar.edit', compact('kos', 'kamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kos $kos, Kamar $kamar)
    {
        $request->validate([
            'nama_kamar' => 'required',
            'harga' => 'required|numeric',
        ]);

        $kamar->update($request->only([
            'nama_kamar',
            'harga',
            'fasilitas',
            'status'
        ]));

        return redirect()->route('kos.show', $kos->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kos $kos, Kamar $kamar)
    {
        $kamar->delete();

        return redirect()->route('kos.show', $kos->id);
    }
}
