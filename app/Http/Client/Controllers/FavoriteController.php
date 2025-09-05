<?php

namespace App\Http\client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function index()
    {
        $products = auth()->user()->favoriteProducts()->paginate(20);
        return view('client.profile.favorite', compact('products'));
    }

    public function store(Product $product)
    {
        auth()->user()->favorites()->firstOrCreate([
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Товар додано в обрані');
    }

    public function destroy(Product $product)
    {
        auth()->user()->favorites()->where('product_id', $product->id)->delete();

        return back()->with('success', 'Товар видалено з обраних');
    }
}
