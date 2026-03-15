<?php

namespace App\Http\Controllers;

use App\Models\Ressources;
use Illuminate\Http\Request;

class RessourcesController extends Controller
{
    public function index()
    {
        $ressources = Ressources::all();

        return view('ressource.index', compact('ressources'));
    }

    public function create()
    {
        return view('ressource.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ressource' => 'required',
        ], [
            'name_ressource.required' => 'Le nom de la ressource est obligatoire.',
        ]);

        Ressources::create([
            'name_ressource' => $request->name_ressource,
        ]);

        return redirect()->route('ressources.index');
    }

    public function show($id)
    {
        $ressource = Ressources::findOrFail($id);

        return view('ressources.show', compact('ressource'));
    }

    public function edit($id)
    {
        $ressource = Ressources::findOrFail($id);

        return view('ressources.edit', compact('ressource'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ressource' => 'required|string|max:255',
        ]);

        $ressource = Ressources::findOrFail($id);

        $ressource->update([
            'name_ressource' => $request->name_ressource,
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
