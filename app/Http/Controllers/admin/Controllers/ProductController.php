<?php

namespace App\Http\Controllers\admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $statuses = Product::statusesList();
        $categories = Category::where('type', 'product')->pluck('name', 'id');
        return view('admin.products.create', compact('statuses','brands', 'categories'));
    }
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Продукт успішно створено!');
    }


}
