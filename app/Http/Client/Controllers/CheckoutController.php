<?php

namespace App\Http\Client\Controllers;

use App\Events\ConfirmOrder;
use App\Http\Client\Requests\CheckoutRequest;
use App\Http\Controllers\Controller;
use App\Models\Location;
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

    public function process(CheckoutRequest $request)
    {
        $validated = $request->validated();

        $order = Checkout::processOrder($validated);

        if ($validated['payment_method'] === 'online') {
            return redirect()->route('payment.gateway', $order)
                ->with('message', 'Перенаправлення на сторінку оплати...');
        }
        
        ConfirmOrder::dispatch($order);

        return redirect()->route('client.dashboard')
            ->with('message', 'Ваше замовлення успішно оформлено!');
    }
    public function suggest(Request $request)
    {
        $q = $request->get('q', '');

        $results = Location::query()
            ->limit(20)
            ->where('name', 'like', "%{$q}%")
            ->get(['id', 'name'])
            ->unique('name')
            ->take(20)
            ->values();

        $formatted = $results->map(fn($settlement) => [
            'id' => $settlement->id,
            'text' => $settlement->name,
        ]);

        return response()->json(['results' => $formatted]);
    }
}
