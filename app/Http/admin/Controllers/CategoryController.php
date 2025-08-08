<?php

namespace App\Http\admin\Controllers;

use App\Http\admin\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create(Category $category)
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Категорію успішно створено!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact( 'category'));
    }

    public function update(CategoryRequest $request, Category $category)  
    {
        $data = $request->validated();

        Category::findOrFail($category->id)->update($data);

        return redirect()->route('posts.index')->with('success', 'Категорію успішно оновлено!');
    
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('posts.index')->with('success','Категорію видалено');
    }
}
