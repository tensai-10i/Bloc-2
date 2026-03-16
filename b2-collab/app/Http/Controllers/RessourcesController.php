<?php

namespace App\Http\Controllers;

use App\Models\Ressources;
use App\Models\Category;
use App\Models\TypeRessource;
use Illuminate\Http\Request;

class RessourcesController extends Controller
{
    public function index()
    {
        $ressources = Ressources::with('category', 'type')->paginate(15);

        return view('ressource.index', compact('ressources'));
    }

    public function create()
    {
        $categories = Category::all();
        $types = TypeRessource::all();

        return view('ressource.create', compact('categories', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ressource' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_cat' => 'nullable|exists:category,id_cat',
            'id_typeressource' => 'nullable|exists:types_ressources,id_typeressource',
        ], [
            'name_ressource.required' => 'Le nom de la ressource est obligatoire.',
            'id_cat.exists' => 'La catégorie sélectionnée n\'existe pas.',
            'id_typeressource.exists' => 'Le type sélectionné n\'existe pas.',
        ]);

        Ressources::create([
            'name_ressource' => $request->name_ressource,
            'description' => $request->description,
            'id_cat' => $request->id_cat,
            'id_typeressource' => $request->id_typeressource,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('ressources.index')->with('success', 'Ressource créée avec succès');
    }

    public function show($id)
    {
        $ressource = Ressources::with('category', 'type', 'user')->findOrFail($id);

        return view('ressource.show', compact('ressource'));
    }

    public function edit($id)
    {
        $ressource = Ressources::findOrFail($id);
        $categories = Category::all();
        $types = TypeRessource::all();

        return view('ressource.edit', compact('ressource', 'categories', 'types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ressource' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_cat' => 'nullable|exists:category,id_cat',
            'id_typeressource' => 'nullable|exists:types_ressources,id_typeressource',
        ]);

        $ressource = Ressources::findOrFail($id);

        $ressource->update([
            'name_ressource' => $request->name_ressource,
            'description' => $request->description,
            'id_cat' => $request->id_cat,
            'id_typeressource' => $request->id_typeressource,
        ]);

        return redirect()
            ->route('ressources.index')
            ->with('success', 'Ressource modifiée avec succès');
    }

    public function destroy($id)
    {
        $ressource = Ressources::findOrFail($id);

        $ressource->delete();

        return redirect()
            ->route('ressources.index')
            ->with('success', 'Ressource supprimée avec succès');
    }
}

