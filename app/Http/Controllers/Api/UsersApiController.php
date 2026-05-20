<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UsersApiController extends Controller
{
    protected function ensureAdmin(Request $request)
    {
        if (! $request->user() || $request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya admin yang dapat mengakses resource ini',
            ], 403);
        }

        return null;
    }

    public function index(Request $request)
    {
        if ($resp = $this->ensureAdmin($request)) {
            return $resp;
        }

        $query = User::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->q}%")
                    ->orWhere('email', 'like', "%{$request->q}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'message' => 'Daftar user berhasil diambil',
            'data' => $users,
        ]);
    }

    public function show(Request $request, $id)
    {
        if ($resp = $this->ensureAdmin($request)) {
            return $resp;
        }

        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail user berhasil diambil',
            'data' => $user,
        ]);
    }

    public function store(Request $request)
    {
        if ($resp = $this->ensureAdmin($request)) {
            return $resp;
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,pemilik,user'],
            'no_telepon' => ['nullable', 'string', 'max:50'],
        ]);

        if ($data['role'] === 'admin' && User::where('role', 'admin')->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Admin hanya boleh satu akun.',
            ], 409);
        }

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        if ($resp = $this->ensureAdmin($request)) {
            return $resp;
        }

        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,pemilik,user'],
            'no_telepon' => ['nullable', 'string', 'max:50'],
        ]);

        if ($data['role'] === 'admin' && User::where('role', 'admin')->where('id', '!=', $user->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Admin hanya boleh satu akun.',
            ], 409);
        }

        $user->fill([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'role' => $data['role'],
            'no_telepon' => $data['no_telepon'],
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui',
            'data' => $user,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        if ($resp = $this->ensureAdmin($request)) {
            return $resp;
        }

        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        if ($request->user()->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus akun sendiri.',
            ], 400);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus',
        ]);
    }
}
