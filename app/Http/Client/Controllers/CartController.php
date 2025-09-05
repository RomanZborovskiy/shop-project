<?php

namespace App\Http\client\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::getCart();
        return view('client.cart.index', ['cart' => $cart]);
    }

    public function add(Request $request, Product $product)
    {
        $quantity = max((int) $request->input('quantity', 1), 1);
        Cart::addProduct($product, $quantity);

        return redirect()->back()->with('success', 'Товар додано до кошика!');
    }

    public function update(Request $request, Purchase $purchase)
    {
        $quantity = (int) $request->input('quantity', 1);
        Cart::updatePurchase($purchase, $quantity);

        return redirect()->route('cart.index')->with('success', 'Кількість товару оновлено.');
    }

    public function remove(Purchase $purchase)
    {
        Cart::removePurchase($purchase);

        return redirect()->route('cart.index')->with('success', 'Товар видалено з кошика.');
    }
}