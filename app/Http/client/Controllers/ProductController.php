<?php

namespace App\Http\client\Controllers;

use App\Exports\ProductsExport;
use App\Facades\Currency;
use App\Http\admin\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\Term;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only([
            'price_from',
            'price_to',
            'brand_id',
            'sort_by',
            'direction',
        ]);
        
        $products = Product::with(['brand', 'category', 'reviews'])->filter($filters)->paginate(9);
        $brands = Brand::orderBy('name')->get();
        
        return view('client.pages.shop', compact('products','brands'));
    }

    public function show(Product $product)
    {
        $product->load([
        'brand',
        'category',
        'reviews' => function ($q) {
            $q->whereNull('parent_id')
              ->with(['user', 'replies.user', 'replies.replies']);
        }
    ]);

    return view('client.catalog.single_product', compact('product'));
    }

    public function searchByName(Request $request)
    {
        $filters = $request->only([
            'name',
        ]);

        $products = Product::query()->filter($filters)->paginate(9);

        return view('client.pages.search', compact('products'));
    }

}
