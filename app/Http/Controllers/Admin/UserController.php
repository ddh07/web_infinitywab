<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'is_admin', 'email_verified_at', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:filter', 'max:255', 'unique:users'],
            'is_admin' => ['sometimes', 'boolean'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => (bool) ($validated['is_admin'] ?? false),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user->only(['id', 'name', 'email', 'created_at'])
        ], 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user->only(['id', 'name', 'email', 'is_admin', 'email_verified_at', 'created_at']));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email:filter', 'max:255', 'unique:users,email,' . $id],
            'is_admin' => ['sometimes', 'boolean'],
            'password' => ['sometimes', 'confirmed', Rules\Password::defaults()],
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user->only(['id', 'name', 'email', 'is_admin', 'created_at'])
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting the current admin user
        if ($user->id === Auth::id()) {
            return response()->json([
                'message' => 'Cannot delete your own account'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    public function resendVerificationEmail($id)
    {
        $user = User::findOrFail($id);

        if (! $user instanceof MustVerifyEmail) {
            return response()->json([
                'message' => 'Ce compte ne prend pas en charge la verification email.',
            ], 422);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Cet utilisateur a deja verifie son adresse email.',
            ], 422);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Email de verification renvoye avec succes.',
        ]);
    }
}
