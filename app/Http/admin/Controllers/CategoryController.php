<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Term;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Term::where('vocabulary', 'categories')->defaultOrder()->get()->toTree();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Term::where('vocabulary', 'categories')->pluck('name', 'id');
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'slug'      => 'nullable|string|unique:terms,slug',
            'parent_id' => 'nullable|exists:terms,id',
        ]);

        $data['vocabulary'] = 'categories';

        Term::create($data);

        return redirect()->route('categories.index')->with('success', 'Категорія створена');
    }

    public function edit(Term $category)
    {
        $categories = Term::where('vocabulary', 'categories')
            ->where('id', '!=', $category->id) 
            ->pluck('name', 'id');


        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Term $category)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'slug'      => 'nullable|string|unique:terms,slug,' . $category->id,
            'parent_id' => 'nullable|exists:terms,id',
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Категорія оновлена');
    }

    public function destroy(Term $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Категорія видалена');
    }

    // public function index()
    // {
    //     $categories = Category::paginate(10);
    //     return view('admin.categories.index', compact('categories'));
    // }

    // public function create(Category $category)
    // {
    //     return view('admin.categories.create');
    // }

    // public function store(CategoryRequest $request)
    // {
    //     $data = $request->validated();
    //     Category::create($data);

    //     return redirect()->route('admin.categories.index')->with('success', 'Категорію успішно створено!');
    // }

    // public function edit(Category $category)
    // {
    //     return view('admin.categories.edit', compact( 'category'));
    // }

    // public function update(CategoryRequest $request, Category $category)  
    // {
    //     $data = $request->validated();

    //     Category::findOrFail($category->id)->update($data);

    //     return redirect()->route('posts.index')->with('success', 'Категорію успішно оновлено!');
    
    // }

    // public function destroy(Category $category)
    // {
    //     $category->delete();

    //     return redirect()->route('posts.index')->with('success','Категорію видалено');
    // }
}
