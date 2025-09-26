<?php

namespace App\Http\admin\Controllers;

use App\Actions\SaveSeoAction;
use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
public function index()
    {
        $terms = Term::get();

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
            'seo' => 'array',
            'seo.title' => 'nullable|string|max:255',
            'seo.description' => 'nullable|string|max:500',
            'seo.keywords' => 'nullable|string|max:255',
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

            SaveSeoAction::run($term, $data['seo'] ?? []);
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
            'seo' => 'array',
            'seo.title' => 'nullable|string|max:255',
            'seo.description' => 'nullable|string|max:500',
            'seo.keywords' => 'nullable|string|max:255',
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

        SaveSeoAction::run($category, $data['seo'] ?? []);

        return redirect()->route('admin.categories.edit');
    }

    public function destroy(Term $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index');
    }

    public function order(Request $request)
    {
        $this->validate($request, [
            'data' => 'required|array'
        ]);

        $entities = build_linear_array_sort($request->data);

        foreach ($entities as $item) {
            optional(Term::find($item['id']))->update($item);
        }

        return response()
            ->json(['message' => 'Ok']);
    }
}
    
