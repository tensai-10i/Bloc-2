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
        $ressources = Ressources::with(['typeRessource', 'category'])->paginate(10);
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
            'name_ressource'   => 'required|string|max:255',
            'description'      => 'nullable|string',
            'category_id'      => 'nullable|exists:category,id_cat',
            'type_id'          => 'nullable|exists:types_ressources,id_typeressource',
        ], [
            'name_ressource.required' => 'Le nom de la ressource est obligatoire.',
            'category_id.exists'      => 'La catégorie sélectionnée n\'existe pas.',
            'type_id.exists'          => 'Le type sélectionné n\'existe pas.',
        ]);

        Ressources::create([
            'name_ressource' => $request->name_ressource,
            'description'    => $request->description,
            'category_id'    => $request->category_id,
            'type_id'        => $request->type_id,
            'user_id'        => auth()->id(),
        ]);

        return redirect()->route('ressources.index')->with('success', 'Ressource créée avec succès');
    }

    public function show($id)
    {
        $ressource = Ressources::with('category', 'typeRessource')->findOrFail($id);

        return view('ressource.show', compact('ressource'));
    }

    public function edit($id)
    {
        $ressource = Ressources::findOrFail($id);

        if (auth()->id() !== $ressource->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $categories = Category::all();
        $types      = TypeRessource::all();

        return view('ressource.edit', compact('ressource', 'categories', 'types'));
    }

    public function update(Request $request, $id)
    {
        $ressource = Ressources::findOrFail($id);

        if (auth()->id() !== $ressource->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'name_ressource'   => 'required|string|max:255',
            'description'      => 'nullable|string',
            'id_cat'           => 'nullable|exists:category,id_cat',
            'id_typeressource' => 'nullable|exists:types_ressources,id_typeressource',
        ]);

        $ressource->update($data);

        return redirect()->route('ressources.index')->with('success', 'Ressource mise à jour.');
    }
    public function destroy($id)
    {
        $ressource = Ressources::findOrFail($id);

        if (auth()->id() !== $ressource->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $ressource->delete();
        return redirect()->route('ressources.index')->with('success', 'Ressource supprimée.');
    }
}
