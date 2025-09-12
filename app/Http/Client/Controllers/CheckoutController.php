<?php

namespace App\Http\client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\location;
use App\Facades\Checkout;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Checkout::getCartForCheckout();

        if (!$cart || $cart->purchases->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Ваш кошик порожній.');
        }

        return view('client.cart.checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        $validated = $request->validated();

        $order = Checkout::processOrder($validated);

        if ($validated['payment_method'] === 'online') {
            return redirect()->route('payment.gateway', $order)
                ->with('message', 'Перенаправлення на сторінку оплати...');
        }

        return redirect()->route('client.dashboard')
            ->with('message', 'Ваше замовлення успішно оформлено!');
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
