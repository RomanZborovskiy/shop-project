<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartService
{
    protected ?Order $order = null;

    public function getCart(): Order
    {
        if ($this->order) {
            return $this->order;
        }

        if (Auth::check()) {
            $cart = Order::where('user_id', Auth::id())
                        ->where('type', Order::TYPE_CART)
                        ->first();
            if ($cart) {
                return $this->order = $cart;
            }
        }

        $cartId = Cookie::get('cart_id');
        if ($cartId) {
            $cart = Order::where('id', $cartId)
                        ->where('type', Order::TYPE_CART)
                        ->first();
            if ($cart) {
                return $this->order = $cart;
            }
        }

        $cart = Order::create([
            'user_id' => Auth::id() ?? null,
            'type'    => Order::TYPE_CART,
            'status'  => Order::NEW_STATUS,
        ]);

        Cookie::queue('cart_id', $cart->id, 60 * 24 * 7);

        return $this->order = $cart;
    }

    public function getCount(): int
    {
        return $this->getCart()->purchases() ->sum('quantity');
    }

    public function mergeGuestCartIntoUserCart(): void
    {
        if (!Auth::check()) {
            return;
        }

        $guestCartId = Cookie::get('cart_id');
        if (!$guestCartId) {
            return;
        }

        $guestCart = Order::where('id', $guestCartId)
            ->where('type', Order::TYPE_CART)
            ->first();

        if (!$guestCart) {
            return;
        }

        $userCart = Order::firstOrCreate(
            ['user_id' => Auth::id(), 'type' => Order::TYPE_CART],
            ['status' => Order::NEW_STATUS]
        );

        foreach ($guestCart->purchases as $purchase) {
            $existing = $userCart->purchases()
                ->where('product_id', $purchase->product_id)
                ->first();

            if ($existing) {
                $existing->quantity += $purchase->quantity;
                $existing->save();
            } else {
                $userCart->purchases()->create([
                    'product_id' => $purchase->product_id,
                    'quantity'   => $purchase->quantity,
                    'price'      => $purchase->price,
                ]);
            }
        }

        $userCart->recalculateTotalPrice();

        $guestCart->delete();
        Cookie::queue(Cookie::forget('cart_id'));
    }

    public function addProduct(Product $product, int $quantity = 1): void
    {
        $cart = $this->getCart();

        $purchase = $cart->purchases()->where('product_id', $product->id)->first();

        if ($purchase) {
            $purchase->quantity += $quantity;
            $purchase->save();
        } else {
            $cart->purchases()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
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
