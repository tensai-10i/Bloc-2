<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users (admin only).
     */
    public function index(): View
    {
        $users = User::with('role')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing the user's role (admin only).
     */
    public function editRole(User $user): View
    {
        /** @var \App\Models\User|null $actor */
        $actor = Auth::user();

        $rolesQuery = Role::query();

        if (!$actor?->isSuperAdmin()) {
            $rolesQuery->where('name', '!=', 'super_admin');
        }

        $roles = $rolesQuery->get();

        return view('admin.users.edit-role', compact('user', 'roles'));
    }

    /**
     * Update the user's role (admin only).
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        /** @var \App\Models\User|null $actor */
        $actor = Auth::user();

        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $selectedRole = Role::findOrFail($validated['role_id']);

        if (!$actor?->isSuperAdmin() && $selectedRole->name === 'super_admin') {
            throw ValidationException::withMessages([
                'role_id' => 'Vous ne pouvez pas attribuer le role Super Administrateur.',
            ]);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Rôle de l\'utilisateur mis à jour avec succès!');
    }

    /**
     * Display the specified user's profile.
     */
    public function show(User $user)
    {
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit(User $user)
    {
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('profile.show', $user)->with('success', 'Profile updated successfully!');
    }
}
