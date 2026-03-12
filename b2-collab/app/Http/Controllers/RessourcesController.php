<?php

namespace App\Http\Controllers;

use App\Models\RessourcesModels;
use Illuminate\Http\Request;

class RessourcesController extends Controller
{
    public function index()
    {
        $ressources = RessourcesModels::all();
        return view('ressource.index', compact('ressources'));
    }
}
