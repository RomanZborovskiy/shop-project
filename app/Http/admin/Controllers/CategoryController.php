<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use Fomvasss\SimpleTaxonomy\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
public function index()
    {
        $terms = Term::defaultOrder()->get()->toTree();

        return view('admin.categories.index', compact('terms'));
    }

    public function create($parentId = null)
    {
        return view('admin.categories.create', compact('parentId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:terms,id',
        ]);

        DB::transaction(function () use ($data) {
            $term = Term::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'vocabulary' => 'categories',
            ]);

            if (!empty($data['parent_id'])) {
                $parent = Term::findOrFail($data['parent_id']);
                $term->appendToNode($parent)->save();
            } else {
                $term->saveAsRoot();
            }
        });

        return redirect()->route('admin.categories.index');
    }

    public function edit(Term $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Term $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:terms,id',
        ]);

        $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);

        if (!empty($data['parent_id'])) {
            $parent = Term::findOrFail($data['parent_id']);
            $category->appendToNode($parent)->save();
        } else {
            $category->saveAsRoot();
        }

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Term $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index');
    }

    public function order(Request $request)
    {
        $nodeList = $request->input('order', []);

        if (!empty($nodeList)) {
            Term::rebuildTree($nodeList, true);
        }

        return response()->json(['status' => 'ok']);
    }
}
    
