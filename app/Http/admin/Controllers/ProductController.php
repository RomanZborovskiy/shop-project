<?php

namespace App\Http\admin\Controllers;

use App\Http\admin\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand', 'category'])->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create(Product $product)
    {
        $brands = Brand::all()->pluck('name', 'id');
        $categories = Category::where('type', 'product');

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
        $brands = Brand::get();
        $categories = Category::where('type', 'product');
        $attributes = Attribute::where('category_id', $product->id)->get();

        return view('admin.products.edit', compact('brands','product', 'categories','attributes'));
    }

    public function update(ProductRequest $request, Product $product)  {
        $data = $request->validated();

        Product::findOrFail($product->id)->update($data);

        return redirect()->route('products.index')->with('success', 'Продукт успішно оновлено!');
    
    }

    public function destroy(Product $product){
        $product->delete();

        return redirect()->route('products.index')->with('success','Продукти видалено');
    }
}
