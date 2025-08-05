<?php

namespace App\Http\Controllers\admin\Controllers;

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
    }

    public function create(Product $product)
    {
        $brands = Brand::all();
        $attributes = Attribute::all();
        $categories = Category::where('type', 'product')->get();
        
        return view('admin.components.product.add-product', 
        compact( 'attributes','brands', 'categories'));
    }
}
