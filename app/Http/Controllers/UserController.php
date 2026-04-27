<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * GET /users  (Admin only)
     */
    public function index(Request $request)
    {
        $this->authorizeRole($request, 'admin');

        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        return response()->json(['users' => $query->get()]);
    }

    /**
     * GET /users/:id  (Auth)
     */
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Hanya diri sendiri atau admin yang bisa lihat detail
        if ($request->user()->id !== (int)$id && $request->user()->role !== 'admin') {
            return response()->json(['error' => 'Tidak memiliki izin.'], 403);
        }

        return response()->json($user);
    }

    /**
     * PATCH /users/:id  (Auth - diri sendiri / admin)
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->user()->id !== (int)$id && $request->user()->role !== 'admin') {
            return response()->json(['error' => 'Tidak memiliki izin.'], 403);
        }

        $validated = $request->validate([
            'name'       => 'sometimes|string|max:255',
            'phone'      => 'sometimes|string|max:20',
            'avatar_url' => 'sometimes|url|nullable',
        ]);

        $user->update($validated);

        return response()->json($user->fresh());
    }

    /**
     * DELETE /users/:id  (Admin only)
     */
    public function destroy(Request $request, $id)
    {
        $this->authorizeRole($request, 'admin');

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

    // ─── Helper ──────────────────────────────────────────────────────────────
    private function authorizeRole(Request $request, string $role)
    {
        if ($request->user()->role !== $role) {
            abort(403, 'Tidak memiliki izin.');
        }
    }
}