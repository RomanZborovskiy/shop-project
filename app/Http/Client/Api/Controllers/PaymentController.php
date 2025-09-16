<?php

namespace App\Http\client\Controllers;

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
            return response()->json([
                'success' => false,
                'message' => 'Не вдалося створити посилання для оплати',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'checkout_url' => $checkoutUrl,
        ]);
    }

    public function handleResponse(Request $request)
    {
        $status = $request->input('order_status');

        return response()->json([
            'success' => $status === 'approved',
            'status'  => $status,
            'message' => $status === 'approved'
                ? 'Дякуємо! Ваш платіж обробляється.'
                : 'Оплата не завершена.',
        ]);
    }

    public function handleCallback(Request $request)
    {
        $callbackData = json_decode($request->getContent(), true);

        if (empty($callbackData)) {
            return response()->json([
                'success' => false,
                'message' => 'Некоректні дані',
            ], 400);
        }

        $ok = Payment::processCallback($callbackData);

        return response()->json([
            'success' => $ok,
            'message' => $ok ? 'OK' : 'Fail',
        ], $ok ? 200 : 400);
    }
}
