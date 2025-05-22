<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    // Tampilkan semua pengguna
    public function index()
    {
        return response()->json(User::all());
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => ['required', Rule::in([
                'koordinator_unit', 'koordinator_menris', 'koordinator_mutu',
                'kepala_puskesmas', 'dinas_kesehatan', 'admin'
            ])],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return response()->json([
            'message' => 'User created successfully.',
            'user'    => $user,
        ], 201);
    }

    // Detail user berdasarkan ID
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'email'    => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role'     => ['sometimes', Rule::in([
                'koordinator_unit', 'koordinator_menris', 'koordinator_mutu',
                'kepala_puskesmas', 'dinas_kesehatan', 'admin'
            ])],
        ]);

        $user->update([
            'name'     => $validated['name'] ?? $user->name,
            'email'    => $validated['email'] ?? $user->email,
            'password' => isset($validated['password']) ? Hash::make($validated['password']) : $user->password,
            'role'     => $validated['role'] ?? $user->role,
        ]);

        return response()->json([
            'message' => 'User updated successfully.',
            'user'    => $user,
        ]);
    }

    // Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully.',
        ]);
    }
}