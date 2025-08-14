<?php

namespace App\Http\admin\Controllers;

use App\Http\admin\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
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
        $categories = Category::where('type', 'product')->get()->toTree();;

        return view('admin.products.create', compact('brands', 'categories'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        
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
}
