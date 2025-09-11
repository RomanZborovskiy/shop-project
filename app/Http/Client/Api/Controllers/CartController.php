<?php

namespace App\Http\Client\Api\Controllers;

use App\Facades\Cart;
use App\Http\Client\Api\Resources\CartResource;
use App\Http\Client\Api\Resources\CategoryResource;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Term;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::getCart();

        return CartResource::make($cart);
    }

    public function add(Request $request, Product $product)
    {
        $qty = max((int) $request->input('qty', 1), 1);

        Cart::addProduct($product, $qty);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
        ]);
    }

    public function remove(Request $request, Purchase $purchase)
    {
        $qty = (int) $request->input('qty', 1);

        if ($qty > 0 && $purchase->quantity > $qty) {
            $purchase->update(['quantity' => $purchase->quantity - $qty]);
            $purchase->order->recalculateTotalPrice();
        } else {
            Cart::removePurchase(($purchase));
        }

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
        ]);
    }

    public function checkout (Request $request)
    {
        $cartId = Cookie::get('cart_id');
        if (!$cartId) {
            return response()->json([
                'success' => false,
                'message' => 'Ваш кошик порожній.',
            ], 400);
        }

        $order = Order::find($cartId);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Замовлення не знайдено.',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'settlement_id' => 'nullable|exists:locations,id',
            'delivery' => 'required|string|max:255',
            'payment_method' => 'required|in:cash_on_delivery,online',
        ]);

        $user = Auth::user();

        if (!$user) {
            $user = User::where('email', $validated['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make(Str::random(8)), 
                ]);
            }
        }

        $order->update([
            'user_id' => $user->id,
            'type' => 'order',
            'status' => 'pending',
            'user_info' => $validated,
        ]);

        $order->recalculateTotalPrice();

        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'total_price' => currency_convert($order->total_price, currency_active()),
            'currency' => currency_active(),
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'transaction_id' => null, 
        ]);

        if ($validated['payment_method'] === 'online') {
            $paymentUrl = route('payment.gateway', $order);

            return response()->json([
                'success' => true,
                'message' => 'Перенаправлення на сторінку оплати...',
                'redirect_url' => $paymentUrl,
                'order_id' => $order->id,
                'payment_id' => $payment->id,
            ]);
        } else {
            $order->update(['status' => 'processing']);
        }

        Cookie::queue(Cookie::forget('cart_id'));

        return response()->json([
            'success' => true,
            'message' => 'Ваше замовлення успішно оформлено!',
            'order_id' => $order->id,
            'payment_id' => $payment->id,
        ]);
    }
}
