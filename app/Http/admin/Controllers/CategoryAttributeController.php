<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Term;
use Illuminate\Http\Request;

class CategoryAttributeController extends Controller
{
    public function index()
    {
        $categories = Term::all();

        return view('admin.category_attributes.index', compact('categories'));
    }
    public function edit($categoryId)
    {
        $category = Term::findOrFail($categoryId);
        $attributes = Attribute::all();
        $selected = $category->attributes->pluck('id')->toArray();

        return view('admin.category_attributes.edit', compact('category', 'attributes', 'selected'));
    }

    public function update(Request $request, $categoryId)
    {
        $category = Term::findOrFail($categoryId);

        $category->attributes()->sync($request->input('attributes', [])); 

        return redirect()->back()->with('success', 'Атрибути оновлено!');
    }
}
