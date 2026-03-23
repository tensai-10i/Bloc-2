<?php

namespace App\Http\Controllers;

use App\Models\TypeRessource;
use Illuminate\Http\Request;

class TypeRessourceController extends Controller
{
    public function index()
    {
        $types = TypeRessource::all();
        return view('type_ressource.index', compact('types'));
    }

    public function show($id)
    {
        $type = TypeRessource::with('ressources')->findOrFail($id);
        return view('type_ressource.show', compact('type'));
    }

    public function create()
    {
        return view('type_ressource.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_typeressource' => 'required|unique:types_ressources,name_typeressource',
        ], [
            'name_typeressource.required' => 'Le nom du type est obligatoire.',
            'name_typeressource.unique'   => 'Ce type existe déjà.',
        ]);

        TypeRessource::create([
            'name_typeressource' => $request->name_typeressource,
        ]);

        return redirect()->route('type_ressource.index')
            ->with('success', 'Type de ressource créé avec succès.');
    }

    public function edit($id)
    {
        $type = TypeRessource::findOrFail($id);
        return view('type_ressource.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = TypeRessource::findOrFail($id);

        $request->validate([
            'name_typeressource' => 'required|unique:types_ressources,name_typeressource,' . $id . ',id_typeressource',
        ], [
            'name_typeressource.required' => 'Le nom du type est obligatoire.',
            'name_typeressource.unique'   => 'Ce type existe déjà.',
        ]);

        $type->update([
            'name_typeressource' => $request->name_typeressource,
        ]);

        return redirect()->route('type_ressource.index')
            ->with('success', 'Type modifié avec succès.');
    }

    public function destroy($id)
    {
        $type = TypeRessource::findOrFail($id);
        $type->delete();

        return redirect()->route('type_ressource.index')
            ->with('success', 'Type de ressource supprimé.');
    }
}
