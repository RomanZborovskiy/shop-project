<?php

namespace App\Http\admin\Controllers;

use App\Http\admin\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\Term;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addAttribute(Request $request, Product $product)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'attribute_value_id' => 'required|exists:attribute_values,id',
        ]);

        $product->attributeValues()->attach($request->attribute_value_id);

        return back()->with('success', 'Характеристика додана');
    }
    
    public function index()
    {
        $products = Product::with(['brand', 'category'])->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create(Product $product)
    {
        $brands = Brand::all()->pluck('name', 'id');
        return view('admin.products.create', compact('brands'));
    }

    public function store(ProductRequest $request)
    {
         $data = $request->validated();
    
        $data['category_id'] = $request->subcategory_id ?? $request->category_id;
        
        $product = Product::create($data);
        $product->mediaManage($request);
        
        return redirect()->route('products.index')->with('success', 'Продукт успішно створено!');
    }


     public function edit(Request $request, Product $product)
    {
        $brands = Brand::all();
        $categories = Category::where('type', 'product')->get();
        $attributes = Attribute::all();

        $properties = collect();
        if ($request->filled('attribute_id')) {
            $properties = Property::where('attribute_id', $request->attribute_id)->get();
        }

        return view('admin.products.edit', compact(
            'product',
            'brands',
            'categories',
            'attributes',
            'properties'
        ));
    }

    public function update(ProductRequest $request, Product $product)  {
        $data = $request->validated();

        $product->update($data);

        $product->mediaManage($request);

        return redirect()->route('products.index')->with('success', 'Продукт успішно оновлено!');
    
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success','Продукти видалено');
    }

    public function storeAttribute(Request $request, Product $product)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
        ]);

        $product->properties()->attach($request->property_id);

        return redirect()->route('products.index')->with('success', 'Атрибут додано до продукту');
    }

    public function suggest(Request $request)
    {
        $request->validate([
            'parent_id' => 'nullable|integer|exists:terms,id',
            'term' => 'nullable|string|max:255',
        ]);

        \Log::info('Suggest request:', $request->all());

        $query = Term::where('vocabulary', 'categories')
                    ->when($request->term, function($q) use ($request) {
                        $q->where('name', 'like', "%{$request->term}%");
                    });

        if ($request->has('parent_id') && $request->parent_id) {
            \Log::info('Filtering by parent_id:', ['parent_id' => $request->parent_id]);
            $query->where('parent_id', $request->parent_id);
        } else {
            \Log::info('Fetching root categories');
            $query->whereNull('parent_id');
        }

        $results = $query->get()->map(fn($term) => ['id' => $term->id, 'text' => $term->name])->values();
        \Log::info('Suggest results for parent_id: ' . ($request->parent_id ?? 'null'), ['results' => $results]);

        return response()->json(['results' => $results]);
    }
}
