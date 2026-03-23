<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CategoryApiController extends Controller
{
    private function transform(Category $category): array
    {
        return [
            'id'       => $category->id_cat,
            'name_cat' => $category->name_cat,
        ];
    }

    public function index(): JsonResponse
    {
        $categories = Category::all();

        return response()->json($categories->map(fn($c) => $this->transform($c))->values());
    }

    public function show(int $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        return response()->json($this->transform($category));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name_cat' => 'required|string|max:255',
        ]);

        $category = Category::create($validated);

        return response()->json($this->transform($category), 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'name_cat' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        return response()->json($this->transform($category));
    }

    public function destroy(int $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Catégorie supprimée.']);
    }
}
