<?php

namespace App\Http\admin\Controllers;

use App\Http\admin\Requests\AttributeRequest;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::with(['category'])->paginate(10);
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create(Attribute $attribute)
    {
        $categories = Category::all();
        return view('admin.attributes.create', compact('categories'));
    }

    public function store(AttributeRequest $request)
    {
        $data = $request->validated();
        Attribute::create($data);

        return redirect()->route('attributes.index')->with('success', 'Атрибут успішно створено!');
    }

    public function edit(Attribute $attribute)
    {
        $categories = Category::all();
        return view('admin.attributes.edit', compact( 'attribute','categories'));
    }

    public function update(AttributeRequest $request, Attribute $attribute)  
    {
        $data = $request->validated();

        Attribute::findOrFail($attribute->id)->update($data);

        return redirect()->route('posts.index')->with('success', 'Атрибут успішно оновлено!');
    
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->route('posts.index')->with('success','Атрибут видалено');
    }
}
