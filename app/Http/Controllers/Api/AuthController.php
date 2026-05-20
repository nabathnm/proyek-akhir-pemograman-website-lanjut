<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Login dan dapatkan JWT token.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Register user baru.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'       => 'required|string|between:2,100',
            'email'      => 'required|string|email|max:100|unique:users',
            'password'   => 'required|string|min:6',
            'no_telepon' => 'nullable|string|max:20',
            'role'       => 'nullable|in:user,pemilik',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $role = $request->role === 'pemilik' ? 'pemilik' : 'user';

        $user = User::create([
            'nama'       => $request->nama,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'role'       => $role,
        ]);

        $token = auth('api')->login($user);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data'    => [
                'user'         => $user,
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth('api')->factory()->getTTL() * 60,
            ],
        ], 201);
    }

    /**
     * Dapatkan data user yang sedang login.
     */
    public function me()
    {
        return response()->json([
            'success' => true,
            'data'    => auth('api')->user(),
        ]);
    }

    /**
     * Logout (invalidate token).
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout',
        ]);
    }

    /**
     * Refresh JWT token.
     */
    public function refresh()
    {
        try {
            $newToken = auth('api')->refresh();
            return $this->respondWithToken($newToken);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid atau sudah kadaluarsa',
            ], 401);
        }
    }

    /**
     * Format response dengan token.
     */
    protected function respondWithToken(string $token)
    {
        return response()->json([
            'success'      => true,
            'message'      => 'Login berhasil',
            'data'         => [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth('api')->factory()->getTTL() * 60,
                'user'         => auth('api')->user(),
            ],
        ]);
    }
}
