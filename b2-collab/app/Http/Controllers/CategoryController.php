<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }


    public function create()
    {
        return view('category.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_cat' => 'required|max:255'
        ],[
            'name_cat.required' => 'Le champ nom est obligatoire',
        ]);

        Category::create([
            'name_cat' => $request->name_cat
        ]);

        return redirect()->route('category.index');
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name_cat' => 'required|max:255'
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name_cat' => $request->name_cat
        ]);

        return redirect()->route('category.index');
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index');
    }
}
