<?php

namespace App\Http\client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Cloudipsp\Configuration;
use Cloudipsp\Checkout;


class FondyController extends Controller
{
    private function initializeFondy(): void
    {
        Configuration::setMerchantId(config('fondy.merchant_id'));
        Configuration::setSecretKey(config('fondy.secret_key'));
    }
    public function redirectToGateway(Order $order)
    {
        $payment = Payment::where('order_id', $order->id)->firstOrFail();

        if ($payment->payment_status === 'completed') {
            return redirect()->route('client.dashboard')->with('info', 'Це замовлення вже оплачено.');
        }

        Configuration::setMerchantId(config('fondy.merchant_id'));
        Configuration::setSecretKey(config('fondy.secret_key'));

        $data = [
            'order_id'           => $order->id . '_' . time(),
            'order_desc'         => "Оплата замовлення №{$order->id}",
            'amount'             => intval($payment->total_price * 100),
            'currency'           => $payment->currency,
            'response_url'       => route('payment.response'),
            'server_callback_url'=> route('payment.callback'),
            'merchant_data'       => array('order_id' => $order->id),
        ];
        //dd($data);

        $url = Checkout::url($data);

        $result = $url->getData();

        if (isset($result['response_status']) && $result['response_status'] === 'success') {
            return redirect()->to($result['checkout_url']);
        } else {
            Log::error('Fondy redirect error: ' . json_encode($result));
            return redirect()->route('cart.index')->with('error', 'Не вдалося перейти до сторінки оплати. Спробуйте пізніше.');
        }
    }

    public function handleResponse(Request $request)
    {
        $status = $request->input('order_status');
        
        if ($status === 'approved') {
            return redirect()->route('client.dashboard')->with('success', 'Дякуємо! Ваш платіж успішно обробляється. Статус замовлення буде оновлено незабаром.');
        }

        return redirect()->route('cart.index')->with('error', 'Оплата не була завершена. Якщо виникають проблеми, будь ласка, спробуйте ще раз або зверніться до підтримки.');
    }

    public function handleCallback(Request $request)
    {
        $this->initializeFondy();
        
        $callbackData = json_decode($request->getContent(), true);

        if (empty($callbackData)) {
            Log::warning('Fondy Callback: Отримано порожній запит.');
            return response('Bad Request', 400);
        }
        $merchantData = json_decode($callbackData['merchant_data'], true);
        $orderId = $merchantData['order_id'] ?? null;

        if (!$orderId) {
            Log::error('Fondy Callback: ID замовлення не знайдено в merchant_data.', $callbackData);
            return response('Order ID not found', 400);
        }

        if (isset($callbackData['order_status']) && $callbackData['order_status'] == 'approved') {
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
                    Log::info("Fondy Callback: Замовлення #{$orderId} вже було оброблено. Пропускаємо.");
                }
            });
        }
    
        return response('OK', 200);
    }
}
