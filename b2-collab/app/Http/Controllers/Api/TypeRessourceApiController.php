<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TypeRessource;
use Illuminate\Http\JsonResponse;

class TypeRessourceApiController extends Controller
{
    private function transform(TypeRessource $type): array
    {
        return [
            'id' => $type->id_typeressource,
            'name_typeressource' => $type->name_typeressource,
        ];
    }

    public function index(): JsonResponse
    {
        $types = TypeRessource::all();

        return response()->json($types->map(fn($t) => $this->transform($t))->values());
    }

    public function show(int $id): JsonResponse
    {
        $type = TypeRessource::findOrFail($id);

        return response()->json($this->transform($type));
    }
}
