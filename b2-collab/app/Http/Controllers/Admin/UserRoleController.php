<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserRoleController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in(['user', 'moderator', 'admin', 'superadmin'])],
        ]);

        $user->update([
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'role-updated');
    }
}
