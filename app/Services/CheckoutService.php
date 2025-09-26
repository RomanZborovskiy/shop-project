<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CheckoutService
{
    public function getCartForCheckout(): ?Order
    {
        if (Auth::check()) {
            return Order::with('purchases')
                ->where('user_id', Auth::id())
                ->where('type', Order::TYPE_CART)
                ->first();
        }

        $cartId = Cookie::get('cart_id');
        if ($cartId) {
            return Order::with('purchases')
                ->where('id', $cartId)
                ->where('type', Order::TYPE_CART)
                ->first();
        }

        return null;
    }

    public function processOrder(array $validated): Order
    {
        $cartId = Cookie::get('cart_id');
        $order = Order::findOrFail($cartId);

        $user = Auth::user();
        if (!$user) {
            $user = User::where('email', $validated['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name'     => $validated['name'],
                    'email'    => $validated['email'],
                    'password' => Hash::make(Str::random(8)),
                ]);
            }
        }

        $order->update([
            'user_id'   => $user->id,
            'type'      => Order::TYPE_ORDER,
            'status'    => Order::STATUS_PENDING,
            'user_info' => $validated,
        ]);

        $order->recalculateTotalPrice();

        Payment::create([
            'order_id'       => $order->id,
            'user_id'        => $user->id,
            'total_price'    => currency_convert($order->total_price, currency_active()),
            'currency'       => currency_active(),
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'transaction_id' => null,
        ]);

        if ($validated['payment_method'] === 'online') {
            return $order; 
        }

        $order->update(['status' => Order::STATUS_PROCESSING]);

        Cookie::queue(Cookie::forget('cart_id'));

        return $order;
    }
}