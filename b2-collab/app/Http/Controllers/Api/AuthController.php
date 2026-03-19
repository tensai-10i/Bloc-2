<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private function normalizeRoleName(string $role): string
    {
        return match ($role) {
            'superadmin', 'super_admin' => 'super_admin',
            'moderator', 'moderateur' => 'moderateur',
            'admin' => 'admin',
            default => 'user',
        };
    }

    private function toDatabaseRole(string $role): string
    {
        return match ($this->normalizeRoleName($role)) {
            'super_admin' => 'superadmin',
            'moderateur' => 'moderator',
            'admin' => 'admin',
            default => 'user',
        };
    }

    private function toApiUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'role' => $this->normalizeRoleName((string) $user->role),
            'role_id' => $user->role_id,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }

    private function currentRole(Request $request): string
    {
        return $this->normalizeRoleName((string) $request->user()->role);
    }

    private function ensureAdminOrSuperAdmin(Request $request): void
    {
        $role = $this->currentRole($request);
        if (!in_array($role, ['admin', 'super_admin'], true)) {
            abort(403, 'Acces refuse.');
        }
    }

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'user',
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user'  => $this->toApiUser($user),
            'token' => $token,
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Les informations de connexion sont incorrectes.'],
            ]);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        // Supprimer les anciens tokens pour cet appareil
        $user->tokens()->where('name', 'api-token')->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user'  => $this->toApiUser($user),
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnexion réussie.']);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json($this->toApiUser($request->user()));
    }

    public function resendVerificationEmail(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email deja verifie.',
            ], 200);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Email de verification envoye.',
        ], 200);
    }

    public function users(Request $request): JsonResponse
    {
        $this->ensureAdminOrSuperAdmin($request);

        $users = User::query()
            ->orderBy('id')
            ->get()
            ->map(fn (User $user) => $this->toApiUser($user))
            ->values();

        return response()->json($users);
    }

    public function updateUserRole(Request $request, int $id): JsonResponse
    {
        $this->ensureAdminOrSuperAdmin($request);

        $validated = $request->validate([
            'role' => 'required|string|in:user,moderateur,admin,super_admin',
        ]);

        $actorRole = $this->currentRole($request);
        $nextRole = $validated['role'];

        if ($nextRole === 'super_admin' && $actorRole !== 'super_admin') {
            return response()->json([
                'message' => 'Seul un super_admin peut attribuer ce role.',
            ], 403);
        }

        if ($nextRole === 'admin' && !in_array($actorRole, ['admin', 'super_admin'], true)) {
            return response()->json([
                'message' => 'Role non autorise.',
            ], 403);
        }

        $user = User::findOrFail($id);
        $user->role = $this->toDatabaseRole($nextRole);
        $user->save();

        return response()->json([
            'message' => 'Role mis a jour.',
            'user' => $this->toApiUser($user),
        ]);
    }
}
