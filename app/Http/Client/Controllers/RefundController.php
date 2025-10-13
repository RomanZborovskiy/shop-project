<?php

namespace App\Http\Client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RefundController extends Controller
{
     public function refund(Request $request, Payment $payment)
    {
        if ($payment->payment_method !== 'fondy' || $payment->payment_status !== 'approved') {
            return response()->json(['error' => 'Цей платіж не можна повернути'], 400);
        }

        // Якщо передана часткова сума
        $amount = $request->input('amount', $payment->total_price);

        // Fondy очікує amount у копійках
        $refundAmount = (int) ($amount * 100);

        $merchantId = config('services.fondy.merchant_id');
        $secretKey  = config('services.fondy.secret_key');

        $data = [
            'request' => [
                'order_id'   => $payment->order_id,   
                'amount'     => $refundAmount,
                'currency'   => $payment->currency,
                'merchant_id'=> $merchantId,
            ]
        ];

        // Підпис (Fondy вимагає SHA1 hash)
        $signature = $this->generateSignature($data['request'], $secretKey);
        $data['request']['signature'] = $signature;

        // Відправляємо запит у Fondy
        $response = Http::post('https://pay.fondy.eu/api/reverse/order_id', $data);

        $result = $response->json();

        // Оновлюємо БД
        $payment->update([
            'refund_status'   => $result['response']['reverse_status'] ?? 'failed',
            'refunded_amount' => $amount,
            'refund_response' => $result,
        ]);

        return response()->json($result);
    }

    /**
     * Генерація підпису для Fondy
     */
    private function generateSignature(array $data, string $secretKey): string
    {
        ksort($data); // сортуємо по ключах
        $str = $secretKey;
        foreach ($data as $value) {
            $str .= '|' . $value;
        }
        return sha1($str);
    }
}
   