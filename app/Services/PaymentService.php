<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Cloudipsp\Configuration;
use Cloudipsp\Checkout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PaymentService
{
    public function __construct()
    {
        $this->initializeFondy();
    }

    private function initializeFondy(): void
    {
        Configuration::setMerchantId(config('fondy.merchant_id'));
        Configuration::setSecretKey(config('fondy.secret_key'));
    }

    public function generateCheckoutUrl(Order $order): ?string
    {
        $payment = Payment::where('order_id', $order->id)->firstOrFail();

        if ($payment->payment_status === 'completed') {
            return null;
        }

        $data = [
            'order_id'            => $order->id . '_' . time(),
            'order_desc'          => "Оплата замовлення №{$order->id}",
            'amount'              => intval($payment->total_price * 100),
            'currency'            => $payment->currency,
            'response_url'        => route('payment.response'),
            'server_callback_url' => route('payment.callback'),
            'merchant_data'       => json_encode(['order_id' => $order->id]),
        ];

        $url = Checkout::url($data);
        $result = $url->getData();

        if (isset($result['response_status']) && $result['response_status'] === 'success') {
            return $result['checkout_url'];
        }

        Log::error('Fondy redirect error: ' . json_encode($result));
        return null;
    }

    public function processCallback(array $callbackData): bool
    {
        $merchantData = json_decode($callbackData['merchant_data'] ?? '{}', true);
        $orderId = $merchantData['order_id'] ?? null;

        if (!$orderId) {
            Log::error('Fondy Callback: ID замовлення не знайдено в merchant_data.', $callbackData);
            return false;
        }

        if (($callbackData['order_status'] ?? null) === 'approved') {
            DB::transaction(function () use ($orderId, $callbackData) {
                $payment = Payment::where('order_id', $orderId)->lockForUpdate()->first();

                if ($payment && $payment->payment_status !== 'completed') {
                    $payment->payment_status = 'completed';
                    $payment->transaction_id = $callbackData['payment_id'] ?? null;
                    $payment->save();

                    $order = Order::find($orderId);
                    if ($order) {
                        $order->status = 'paid';
                        $order->save();
                    }
                    Log::info("Fondy Callback: Замовлення #{$orderId} успішно оновлено.");
                } else {
                    Log::info("Fondy Callback: Замовлення #{$orderId} вже оброблене.");
                }
            });

            return true;
        }

        return false;
    }
}
