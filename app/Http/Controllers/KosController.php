<?php

namespace App\Http\Controllers;
use App\Models\Kos;

use Illuminate\Http\Request;

class KosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kos = Kos::latest()->get();

        return view('kos.index', compact('kos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kos' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'nullable',
        ]);

        Kos::create([
            'user_id' => 1, // sementara hardcode
            'nama_kos' => $request->nama_kos,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kos $kos)
    {
        $kos->load('kamar');

        return view('kos.show', compact('kos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kos $kos)
    {
        return view('kos.edit', compact('kos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kos $kos)
    {
        $request->validate([
            'nama_kos' => 'required',
            'alamat' => 'required',
        ]);

        $kos->update($request->only([
            'nama_kos',
            'alamat',
            'deskripsi'
        ]));

        return redirect()->route('kos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kos $kos)
    {
        $kos->delete();

        return redirect()->route('kos.index');
    }
}
