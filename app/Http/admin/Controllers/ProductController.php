<?php

namespace App\Http\admin\Controllers;

use App\Http\admin\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand', 'category'])->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create(Product $product)
    {
        $brands = Brand::all();
        $categories = Category::where('type', 'product')->pluck('name', 'id');
        return view('admin.products.create', compact('brands', 'categories'));
    }
    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Продукт успішно створено!');
    }

    public function edit(Product $product)
    {
        $attributes = collect();

        $brands = Brand::all();
        $categories = Category::where('type', 'product')->pluck('name', 'id');

        $categoryId = request('category_id', $product->category_id);

        $attributes = collect();
        if ($categoryId) {
            $attributes = Attribute::where('category_id', $categoryId)->get();
        }
        //dd($attributes);
        return view('admin.products.edit', compact('brands','product', 'categories','attributes'));
    }
}
