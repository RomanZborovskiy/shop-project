<?php

namespace App\Http\client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getOrCreateCart();

        return view('client.cart.index', ['cart' => $cart]);
    }

    public function add(Request $request, Product $product)
    {
        $cart = $this->getOrCreateCart();
        $quantity = max((int) $request->input('quantity', 1), 1);

        $purchase = $cart->purchases()->where('product_id', $product->id)->first();

        if ($purchase) {

            $purchase->quantity = $quantity;
            $purchase->save();
        } else {
            Purchase::create([
                'order_id'   => $cart->id,
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'price'      => $product->price,
            ]);
        }

        $cart->recalculateTotalPrice();

        return redirect()->back()->with('success', 'Товар додано до кошика!');
    }

    public function update(Request $request, Purchase $purchase)
    {
        $quantity = $request->input('quantity', 1);
        
        if ($quantity > 0) {
            $purchase->update(['quantity' => $quantity]);
        } else {
            $purchase->delete();
        }

        $purchase->order->recalculateTotalPrice();

        return redirect()->route('cart.index')->with('success', 'Кількість товару оновлено.');
    }

    public function remove(Purchase $purchase)
    {
        $order = $purchase->order;
        $purchase->delete();
        $order->recalculateTotalPrice();

        return redirect()->route('cart.index')->with('success', 'Товар видалено з кошика.');
    }

    private function getOrCreateCart()
    {
        if (Auth::check()) {
            $cart = Order::where('user_id', Auth::id())->where('type', 'cart')->first();
            if ($cart) {
                return $cart;
            }
        }

        $cartId = Cookie::get('cart_id');
        if ($cartId) {
            $cart = Order::where('id', $cartId)->where('type', 'cart')->first();
            if ($cart) {
                return $cart;
            }
        }
        
        $cart = Order::create([
            'user_id' => Auth::id() ?? null,
            'type' => 'cart',
            'status' => 'new' 
        ]);
        
        Cookie::queue('cart_id', $cart->id, 60 * 24 * 7);

        return $cart;
    }
}
