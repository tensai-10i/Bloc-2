<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ressources;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RessourcesApiController extends Controller
{
    private function normalizeRoleName(string $role): string
    {
        return match ($role) {
            'superadmin', 'super_admin' => 'super_admin',
            'admin' => 'admin',
            'moderator', 'moderateur' => 'moderateur',
            default => 'user',
        };
    }

    private function ensureAdminOrSuperAdmin(Request $request): void
    {
        $role = $this->normalizeRoleName((string) $request->user()->role);
        if (!in_array($role, ['admin', 'super_admin'], true)) {
            abort(403, 'Acces refuse.');
        }
    }

    public function index(): JsonResponse
    {
        $ressources = Ressources::all();

        return response()->json($ressources);
    }

    public function show(int $id): JsonResponse
    {
        $ressource = Ressources::findOrFail($id);

        return response()->json($ressource);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name_ressource' => 'required|string|max:255',
        ]);

        $ressource = Ressources::create($validated);

        return response()->json($ressource, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'name_ressource' => 'required|string|max:255',
        ]);

        $ressource = Ressources::findOrFail($id);
        $ressource->update($validated);

        return response()->json($ressource);
    }

    public function destroy(int $id): JsonResponse
    {
        $ressource = Ressources::findOrFail($id);
        $ressource->delete();

        return response()->json(['message' => 'Ressource supprimée.']);
    }

    public function moderate(Request $request, int $id): JsonResponse
    {
        $this->ensureAdminOrSuperAdmin($request);

        $validated = $request->validate([
            'action' => 'required|string|in:approve,reject',
        ]);

        $ressource = Ressources::findOrFail($id);

        if ($validated['action'] === 'reject') {
            $name = $ressource->name_ressource;
            $ressource->delete();

            return response()->json([
                'message' => 'Ressource rejetee et supprimee.',
                'action' => 'reject',
                'resource' => [
                    'id' => $id,
                    'name_ressource' => $name,
                ],
            ]);
        }

        return response()->json([
            'message' => 'Ressource approuvee.',
            'action' => 'approve',
            'resource' => $ressource,
        ]);
    }
}
