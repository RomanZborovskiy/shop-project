<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function webhookLiqPay(Request $request)
    {
        $data = $request->input('data');
        $decoded = json_decode(base64_decode($data), true);

        Log::info('LiqPay subscription callback:', $decoded);

        if (!$decoded || !isset($decoded['order_id'])) {
            return response('invalid', 400);
        }

        $telegramId = $decoded['sender_phone'] ?? null; 
        $amount = $decoded['amount'] ?? 0;
        $currency = $decoded['currency'] ?? 'UAH';
        $status = $decoded['status'] ?? 'unknown';

        Subscription::updateOrCreate(
            ['subscription_id' => $decoded['order_id']],
            [
                'telegram_id' => $telegramId,
                'amount' => $amount,
                'currency' => $currency,
                'status' => $status,
                'last_payment_date' => now(),
                'user_id' => 1, 
            ]
        );

        return response('ok');
    }

    public function resultLiqPay()
    {
        return "Оплату завершено. Дякуємо!";
    }
}
