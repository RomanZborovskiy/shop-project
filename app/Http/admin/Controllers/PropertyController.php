<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('attribute')->paginate(15);
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $attributes = Attribute::all();
        return view('admin.properties.create', compact('attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:255',
            'attribute_id' => 'nullable|exists:attributes,id',
        ]);

        Property::create($request->only('value', 'attribute_id'));

        return redirect()->route('properties.index')->with('success', 'Властивість створено');
    }

    public function edit(Property $property)
    {
        $attributes = Attribute::all();
        return view('admin.properties.edit', compact('property', 'attributes'));
    }

    public function update(Request $request, Property $property)
    {
        $request->validate([
            'value' => 'required|string|max:255',
            'attribute_id' => 'nullable|exists:attributes,id',
        ]);

        $property->update($request->only('value', 'attribute_id'));

        return redirect()->back()->with('success', 'Властивість оновлено');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Властивість видалено');
    }
}
