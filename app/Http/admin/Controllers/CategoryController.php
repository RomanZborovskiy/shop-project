<?php

namespace App\Http\admin\Controllers;

use App\Http\admin\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
public function index()
    {
        $categories = Term::defaultOrder()->get()->toTree();

        $vocabulary = [
            'has_hierarchy' => true,
            'permissions' => [
                'create' => true,
                'update' => true,
                'delete' => true,
            ],
        ];

        return view('admin.categories.index', compact('categories', 'vocabulary'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

   public function store(Request $request)
    {
        $term = new Term([
            'name'       => $request->name,
            'vocabulary' => 'categories',
        ]);

        if ($request->filled('parent_id')) {
            $parent = Term::findOrFail($request->parent_id);
            $term->appendToNode($parent)->save();
        } else {
            $term->saveAsRoot();
        }


        return redirect()->route('admin.categories.index');
    }

    public function edit(Term $term)
    {
        return view('admin.categories.edit', compact('term'));
    }

    public function update(Request $request, Term $term)
    {
        $term->update($request->only('name', 'parent_id'));
        return redirect()->route('admin.categories.index');
    }

    public function destroy(Term $term)
    {
        $term->delete();
        return redirect()->route('admin.categories.index');
    }

    public function order(Request $request)
    {
        $nodeList = $request->input('order', []);

        \Log::info('Payload для reorder:', $nodeList);

        if (!empty($nodeList)) {
            Term::rebuildTree($nodeList, true); 
        }

        return response()->json(['status' => 'ok']);
    }
}
    // public function index()
    // {
    //     $categories = Term::whereIn('vocabulary', ['categories','articles'])->defaultOrder()->get()->toTree();
    //     return view('admin.categories.index', compact('categories'));
    // }

    // public function create()
    // {
    //     $categories = Term::where('vocabulary', 'categories')->pluck('name', 'id');
    //     return view('admin.categories.create', compact('categories'));
    // }

    // public function store(CategoryRequest $request)
    // {
    //     $data = $request->validated();

    //     $data['vocabulary'] = 'categories';

    //     Term::create($data);

    //     return redirect()->route('categories.index')->with('success', 'Категорія створена');
    // }

    // public function edit(Term $category)
    // {
    //     $categories = Term::where('vocabulary', 'categories')
    //         ->where('id', '!=', $category->id) 
    //         ->pluck('name', 'id');


    //     return view('admin.categories.edit', compact('category', 'categories'));
    // }

    // public function update(CategoryRequest $request, Term $category)
    // {
    //     $data = $request->validated();

    //     $category->update($data);

    //     return redirect()->route('categories.index')->with('success', 'Категорія оновлена');
    // }

    // public function destroy(Term $category)
    // {
    //     $category->delete();
    //     return redirect()->route('categories.index')->with('success', 'Категорія видалена');
    // }

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

