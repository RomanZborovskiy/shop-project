<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartService
{
    public function getCart(): Order
    {
        if (Auth::check()) {
            $cart = Order::where('user_id', Auth::id())
                         ->where('type', 'cart')
                         ->first();
            if ($cart) return $cart;
        }

        $cartId = Cookie::get('cart_id');
        if ($cartId) {
            $cart = Order::where('id', $cartId)->where('type', 'cart')->first();
            if ($cart) return $cart;
        }

        $cart = Order::create([
            'user_id' => Auth::id() ?? null,
            'type' => 'cart',
            'status' => 'new',
        ]);

        Cookie::queue('cart_id', $cart->id, 60 * 24 * 7); 

        return $cart;
    }

    public function addProduct(Product $product, int $quantity = 1): void
    {
        $cart = $this->getCart();

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
    }

    public function updatePurchase(Purchase $purchase, int $quantity): void
    {
        if ($quantity > 0) {
            $purchase->update(['quantity' => $quantity]);
        } else {
            $purchase->delete();
        }

        $purchase->order->recalculateTotalPrice();
    }

    public function removePurchase(Purchase $purchase): void
    {
        $order = $purchase->order;
        $purchase->delete();
        $order->recalculateTotalPrice();
    }
}
