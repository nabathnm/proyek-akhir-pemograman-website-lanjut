<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FasilitasApiController extends Controller
{
    public function index(Request $request)
    {
        $fasilitas = Fasilitas::orderBy('nama_fasilitas')
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'message' => 'Daftar fasilitas berhasil diambil',
            'data' => $fasilitas,
        ]);
    }

    public function show($id)
    {
        $fasilitas = Fasilitas::find($id);

        if (! $fasilitas) {
            return response()->json([
                'success' => false,
                'message' => 'Fasilitas tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail fasilitas berhasil diambil',
            'data' => $fasilitas,
        ]);
    }

    public function store(Request $request)
    {
        if (! Auth::user() || Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya admin yang dapat menambah fasilitas',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => ['required', 'string', 'max:255', 'unique:fasilitas,nama_fasilitas'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $fasilitas = Fasilitas::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Fasilitas berhasil ditambahkan',
            'data' => $fasilitas,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        if (! Auth::user() || Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya admin yang dapat mengubah fasilitas',
            ], 403);
        }

        $fasilitas = Fasilitas::find($id);

        if (! $fasilitas) {
            return response()->json([
                'success' => false,
                'message' => 'Fasilitas tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fasilitas', 'nama_fasilitas')->ignore($fasilitas->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $fasilitas->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Fasilitas berhasil diperbarui',
            'data' => $fasilitas,
        ]);
    }

    public function destroy($id)
    {
        if (! Auth::user() || Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya admin yang dapat menghapus fasilitas',
            ], 403);
        }

        $fasilitas = Fasilitas::find($id);

        if (! $fasilitas) {
            return response()->json([
                'success' => false,
                'message' => 'Fasilitas tidak ditemukan',
            ], 404);
        }

        $fasilitas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fasilitas berhasil dihapus',
        ]);
    }
}
