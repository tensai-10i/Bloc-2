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

    private function transform(Ressources $ressource): array
    {
        return [
            'id'               => $ressource->id_ressource,
            'name_ressource'   => $ressource->name_ressource,
            'description'      => $ressource->description,
            'type_id'          => $ressource->type_id,
            'category_id'      => $ressource->category_id,
            'id_typeressource' => $ressource->type_id,
            'id_cat'           => $ressource->category_id,
        ];
    }

    public function index(): JsonResponse
    {
        $ressources = Ressources::all();

        return response()->json($ressources->map(fn($r) => $this->transform($r))->values());
    }

    public function show(int $id): JsonResponse
    {
        $ressource = Ressources::findOrFail($id);

        return response()->json($this->transform($ressource));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name_ressource' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_typeressource' => 'nullable|integer|exists:types_ressources,id_typeressource',
            'type_id' => 'nullable|integer|exists:types_ressources,id_typeressource',
            'id_cat' => 'nullable|integer|exists:category,id_cat',
            'category_id' => 'nullable|integer|exists:category,id_cat',
        ]);

        $typeId = $validated['type_id'] ?? $validated['id_typeressource'] ?? null;
        $categoryId = $validated['category_id'] ?? $validated['id_cat'] ?? null;

        if (!$typeId || !$categoryId) {
            return response()->json([
                'message' => 'Les champs type et categorie sont obligatoires.',
                'errors' => [
                    'type_id'     => ['Le type est obligatoire.'],
                    'category_id' => ['La categorie est obligatoire.'],
                ],
            ], 422);
        }

        $ressource = Ressources::create([
            'name_ressource' => $validated['name_ressource'],
            'description'    => $validated['description'] ?? null,
            'type_id'        => $typeId,
            'category_id'    => $categoryId,
            'user_id'        => $request->user()?->id,
        ]);

        return response()->json($this->transform($ressource), 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'name_ressource' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_typeressource' => 'nullable|integer|exists:types_ressources,id_typeressource',
            'type_id' => 'nullable|integer|exists:types_ressources,id_typeressource',
            'id_cat' => 'nullable|integer|exists:category,id_cat',
            'category_id' => 'nullable|integer|exists:category,id_cat',
        ]);

        $typeId = $validated['id_typeressource'] ?? $validated['type_id'] ?? null;
        $categoryId = $validated['id_cat'] ?? $validated['category_id'] ?? null;

        if (!$typeId || !$categoryId) {
            return response()->json([
                'message' => 'Les champs type et categorie sont obligatoires.',
                'errors' => [
                    'id_typeressource' => ['Le type est obligatoire.'],
                    'id_cat' => ['La categorie est obligatoire.'],
                ],
            ], 422);
        }

        $ressource = Ressources::findOrFail($id);
        $ressource->update([
            'name_ressource' => $validated['name_ressource'],
            'description'    => $validated['description'] ?? null,
            'type_id'        => $typeId,
            'category_id'    => $categoryId,
        ]);

        return response()->json($this->transform($ressource));
    }

    public function destroy(int $id): JsonResponse
    {
        $ressource = Ressources::findOrFail($id);
        $ressource->delete();

        return response()->json(['message' => 'Ressource supprimée.']);
    }

    public function comments(int $id): JsonResponse
    {
        $ressource = Ressources::findOrFail($id);
        $comments = $ressource->comments()->with('user')->get()->map(fn($c) => [
            'id'         => $c->id_comment,
            'content'    => $c->content,
            'user_name'  => $c->user?->name ?? 'Anonyme',
            'created_at' => $c->created_at?->toDateTimeString(),
        ]);

        return response()->json($comments->values());
    }

    public function addComment(Request $request, int $id): JsonResponse
    {
        $ressource = Ressources::findOrFail($id);
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $comment = $ressource->comments()->create([
            'content' => $validated['content'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'id'         => $comment->id_comment,
            'content'    => $comment->content,
            'user_name'  => $request->user()->name,
            'created_at' => $comment->created_at?->toDateTimeString(),
        ], 201);
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
            'resource' => $this->transform($ressource),
        ]);
    }
}
