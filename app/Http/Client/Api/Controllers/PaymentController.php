<?php

namespace App\Http\Client\Api\Controllers;

use App\Facades\Payment;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @api {get} /api/payment/redirect/:order Перенаправлення на платіжну сторінку
     * @apiName RedirectToGateway
     * @apiGroup Payment
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} order ID замовлення (path param)
     *
     * @apiSuccess {Boolean} success Статус операції
     * @apiSuccess {String} checkout_url Посилання на платіжну сторінку
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "checkout_url": "https://pay.fondy.eu/mJ3sm3sdf9"
     * }
     *
     * @apiErrorExample {json} Помилка:
     * HTTP/1.1 400 Bad Request
     * {
     *   "success": false,
     *   "message": "Не вдалося створити посилання для оплати"
     * }
     */
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

    /**
     * @api {post} /api/payment/response Обробка відповіді після оплати
     * @apiName HandleResponse
     * @apiGroup Payment
     * @apiVersion 1.0.0
     *
     * @apiParam {String="approved","declined"} order_status Статус замовлення
     *
     * @apiSuccess {Boolean} success Чи успішна оплата
     * @apiSuccess {String} status Статус замовлення від платіжної системи
     * @apiSuccess {String} message Повідомлення для користувача
     *
     * @apiSuccessExample {json} Успішна оплата:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "status": "approved",
     *   "message": "Дякуємо! Ваш платіж обробляється."
     * }
     *
     * @apiSuccessExample {json} Неуспішна оплата:
     * HTTP/1.1 200 OK
     * {
     *   "success": false,
     *   "status": "declined",
     *   "message": "Оплата не завершена."
     * }
     */
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

    /**
     * @api {post} /api/payment/callback Callback від Fondy
     * @apiName HandleCallback
     * @apiGroup Payment
     * @apiVersion 1.0.0
     *
     * @apiDescription Викликається платіжною системою Fondy для підтвердження статусу транзакції.
     *
     * @apiParam {String} merchant_data JSON з додатковими даними (містить order_id)
     * @apiParam {String} order_status Статус замовлення ("approved", "declined" тощо)
     * @apiParam {String} [payment_id] ID транзакції в Fondy
     *
     * @apiSuccess {Boolean} success Статус обробки callback
     * @apiSuccess {String} message "OK" у випадку успіху, "Fail" у разі помилки
     *
     * @apiSuccessExample {json} Callback з успішною оплатою:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "message": "OK"
     * }
     *
     * @apiErrorExample {json} Callback з помилкою:
     * HTTP/1.1 400 Bad Request
     * {
     *   "success": false,
     *   "message": "Некоректні дані"
     * }
     */
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
