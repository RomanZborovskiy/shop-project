<?php

namespace App\Http\client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Cloudipsp\Configuration;
use Cloudipsp\Checkout;

class FondyController extends Controller
{
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
            'response_url'       => route('client.dashboard'),
            'server_callback_url'=> route('payment.callback'),
            'merchant_data'      => 'order_id=' . $order->id,
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

    public function handleCallback(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            Log::error('Fondy callback: Empty data received.');
            return response('Error: Empty data', 400);
        }

        Configuration::setMerchantId(config('fondy.merchant_id'));
        Configuration::setSecretKey(config('fondy.secret_key'));

        if (Checkout::isPaymentValid($data) !== true) {
            Log::error('Fondy callback: Invalid signature.', $data);
            return response('Error: Invalid signature', 403);
        }

        $merchantData = json_decode($data['merchant_data'] ?? '{}', true);
        $orderId = $merchantData['order_id'] ?? null;

        if (!$orderId) {
            Log::error('Fondy callback: order_id not found in merchant_data.', $data);
            return response('Error: Missing order_id', 400);
        }

        $order = Order::find($orderId);
        $payment = Payment::where('order_id', $orderId)->first();

        if (!$order || !$payment) {
            Log::error("Fondy callback: Order or Payment not found for order_id: {$orderId}");
            return response('Error: Order not found', 404);
        }

        if ($data['order_status'] === 'approved') {
            if ($payment->payment_status !== 'completed') {
                $payment->update([
                    'payment_status' => 'completed',
                    'transaction_id' => $data['payment_id'] ?? null,
                ]);

                $order->update([
                    'status' => 'processing',
                ]);
            }
        } else {
            $payment->update([
                'payment_status' => 'failed',
            ]);
        }

        return response('OK', 200);
    }
}
