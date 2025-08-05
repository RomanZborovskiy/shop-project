<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        // $products = Product::with(['brand', 'category'])->paginate(10);
        // return view('admin.components.product.add-product', compact('products'));
    }

    public function create(Product $product)
    {
        $brands = Brand::all();
        $attributes = Attribute::all();
        $properties = Property::where('attribute_id',$attributes->id)->get();
        $categories = Category::where('type', 'product')->get();
        
        return view('admin.components.product.add-product', 
        compact( 'attributes','brands', 'categories','properties'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'quantity' => 'required|integer',
            'sku' => 'required|string|unique:products',
            'slug' => 'nullable|string|unique:products',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Продукт успішно створено!');
    }
}
