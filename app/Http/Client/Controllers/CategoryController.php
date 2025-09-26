<?php

namespace App\Http\Client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Term;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Term::whereNull('parent_id')->get(); 
        return view('client.catalog.index', compact('categories'));
    }

    public function show(Request $request, Term $category)
    {
        $filters = $request->only([
            'price_from',
            'price_to',
            'brand_id',
            'sort_by',
            'direction',
        ]);

        $products = $category->products()->filter($filters)->paginate(12);
        $brands   = Brand::orderBy('name')->get();

        return view('client.catalog.show', compact('category', 'products', 'brands'));
    }
}
   