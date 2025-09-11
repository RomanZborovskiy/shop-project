<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['brand', 'category'])->filter($request->all())->paginate(12);

        return ProductResource::collection($products);
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->with(['brand', 'category'])->firstOrFail();
        return ProductResource::make($product);
    }

    public function search(Request $request)
    {
        $q = $request->input('q');

        $products = Product::where('name', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->with(['brand', 'category'])
            ->paginate(12);

        return ProductResource::collection($products);
    }
}
