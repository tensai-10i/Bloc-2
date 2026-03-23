<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ressources;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $ressource)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $ressourceModel = Ressources::findOrFail($ressource);

        $ressourceModel->comments()->create([
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Commentaire ajouté.');
    }
}
