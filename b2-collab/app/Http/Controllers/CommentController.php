<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ressource;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Ressource $ressource)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $ressource->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'Commentaire ajouté !');
    }
}
