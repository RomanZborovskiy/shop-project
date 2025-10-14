<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TelegramBotController extends Controller
{
    public function webhook(Request $request)
    {
        $data = $request->all();

        if (!isset($data['message'])) {
            return response('no message');
        }

        $chatId = $data['message']['chat']['id'];
        $text = $data['message']['text'] ?? '';

        if ($text === '/start') {
            $this->sendMessage($chatId, "Привіт! Я бот .\nВведи /buy щоб оплатити.");
        } elseif ($text === '/buy') {
            $paymentLink = $this->generateLiqPayLink(50, 'order-' . uniqid(), 'Тестова оплата');
            $this->sendMessage($chatId, "Оплата на 50 грн:\n [Перейти до LiqPay]($paymentLink)", 'Markdown');
        }

        return response('ok');
    }

    private function sendMessage($chatId, $text, $parseMode = null)
    {
        $url = "https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage";
        $payload = ['chat_id' => $chatId, 'text' => $text];
        if ($parseMode) $payload['parse_mode'] = $parseMode;
        Http::post($url, $payload);
    }

    private function generateLiqPayLink($amount, $orderId, $description)
    {
        $data = [
            'version' => 3,
            'public_key' => env('LIQPAY_PUBLIC_KEY'),
            'action' => 'pay',
            'amount' => $amount,
            'currency' => 'UAH',
            'description' => $description,
            'order_id' => $orderId,
            'sandbox' => 1,
            'result_url' => env('NGROK_URL') . '/liqpay/result',
            'server_url' => env('NGROK_URL') . '/liqpay/webhook',
        ];
        \Log::info('Telegram sendMessage response:', $data);

        $jsonData = base64_encode(json_encode($data));
        $signature = base64_encode(sha1(env('LIQPAY_PRIVATE_KEY') . $jsonData . env('LIQPAY_PRIVATE_KEY'), true));

        return "https://www.liqpay.ua/api/3/checkout?data={$jsonData}&signature={$signature}";
    }
}
