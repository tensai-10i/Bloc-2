<?php

namespace App\Http\Controllers;

use App\Models\RessourcesModels; // ou ton modèle exact
use Illuminate\Http\Request;

class RessourcesController extends Controller
{
    public function index()
    {
        $ressources = RessourcesModels::all();
        return view('ressource', compact('ressources'));
    }
}
