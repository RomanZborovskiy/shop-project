<?php

namespace App\Http\Client\Controllers;

use App\Facades\Payment;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function redirectToGateway(Order $order)
    {
        $checkoutUrl = Payment::generateCheckoutUrl($order);

        if (!$checkoutUrl) {
            return redirect()->route('cart.index')->with('error', 'Не вдалося перейти до оплати.');
        }

        return redirect()->to($checkoutUrl);
    }

    public function handleResponse(Request $request)
    {
        $status = $request->input('order_status');

        if ($status === 'approved') {
            return redirect()->route('client.dashboard')
                ->with('success', 'Дякуємо! Ваш платіж обробляється.');
        }

        return redirect()->route('cart.index')->with('error', 'Оплата не завершена.');
    }

    public function handleCallback(Request $request)
    {
        $callbackData = json_decode($request->getContent(), true);

        if (empty($callbackData)) {
            return response('Bad Request', 400);
        }

        $ok = Payment::processCallback($callbackData);

        return response($ok ? 'OK' : 'Fail', $ok ? 200 : 400);
    }
}
