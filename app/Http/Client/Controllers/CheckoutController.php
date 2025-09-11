<?php

namespace App\Http\client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\location;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartId = Cookie::get('cart_id');
        
        $cart = Order::with('purchases')->find($cartId);
        
        if (!$cart || $cart->purchases->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Ваш кошик порожній.');
        }

        return view('client.cart.checkout', ['cart' => $cart]);
    }
    public function process(Request $request)
    {
        $cartId = Cookie::get('cart_id');
        if (!$cartId) {
            return redirect()->route('client.dashboard')->with('error', 'Ваш кошик порожній.');
        }

        $order = Order::findOrFail($cartId);

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

        Payment::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'total_price' => currency_convert($order->total_price,currency_active()),
            'currency' => currency_active(),
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'transaction_id' => null, 
        ]);

        if ($validated['payment_method'] === 'online') {
            return redirect()->route('payment.gateway', $order)->with('message', 'Перенаправлення на сторінку оплати...');

        } else {
            $order->update(['status' => 'processing']);
        }
        
        Cookie::queue(Cookie::forget('cart_id'));

        return redirect()->route('client.dashboard')->with('message', 'Ваше замовлення успішно оформлено!');
    }

    public function suggest(Request $request)
    {
        $q = $request->get('q', '');

        $results = Location::query()->where('name', 'like', "%{$q}%")
            ->limit(20000) 
            ->get(['id', 'name'])
            ->unique('name') 
            ->values()
            ->take(20);

        $formatted = $results->map(function ($settlement) {
            return [
                'id' => $settlement->id,
                'text' => $settlement->name,
            ];
        });

        return response()->json(['results' => $formatted]);
    }

}
