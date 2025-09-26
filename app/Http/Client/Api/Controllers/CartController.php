<?php

namespace App\Http\Client\Api\Controllers;

use App\Facades\Cart;
use App\Http\Client\Api\Requests\CartRequest;
use App\Http\Client\Api\Resources\CartResource;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * @api {get} /api/cart Отримати кошик
     * @apiName GetCart
     * @apiGroup Cart
     * @apiVersion 1.0.0
     *
     * @apiSuccess {Object} data Дані про кошик
     * @apiSuccess {Number} data.id ID кошика
     * @apiSuccess {Number} data.total_price Загальна сума
     * @apiSuccess {String} data.currency Валюта
     * @apiSuccess {Object[]} data.items Список товарів у кошику
     * @apiSuccess {Number} data.items.id ID покупки
     * @apiSuccess {Number} data.items.product_id ID продукту
     * @apiSuccess {String} data.items.name Назва продукту
     * @apiSuccess {Number} data.items.quantity Кількість
     * @apiSuccess {Number} data.items.price Ціна за одиницю
     * @apiSuccess {Number} data.items.subtotal Проміжна сума
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "data": {
     *           "id": 29,
     *           "total": "250.00",
     *           "status": "new",
     *           "products": [
     *               {
     *                   "id": 41,
     *                   "quantity": 1,
     *                   "price": "250.00",
     *                   "subtotal": 250,
     *                   "product": {
     *                       "id": 11,
     *                       "name": "Habitat Nomad 2 Door 3 Drawer Sideboard ",
     *                       "price": "250.00",
     *                       "slug": "habitat-nomad-2-door-3-drawer-sideboard"
     *                   }
     *               }
     *           ]
     *       },
     *     ]
     *   }
     * }
     */
    public function index(Request $request)
    {
        $cart = Cart::getCart();

        return CartResource::make($cart);
    }

    /**
     * @api {post} /api/cart/:product/add Додати продукт у кошик
     * @apiName AddToCart
     * @apiGroup Cart
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} product ID продукту (path param)
     * @apiParam {Number} [qty=1] Кількість товару
     *
     * @apiSuccess {Boolean} success Статус операції
     * @apiSuccess {String} message Повідомлення
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "message": "Продукт додано до корзини"
     * }
     */
    public function add(Request $request, Product $product)
    {
        $qty = max((int) $request->input('qty', 1), 1);

        Cart::addProduct($product, $qty);

        return response()->json([
            'success' => true,
            'message' => 'Продукт додано до корзини',
        ]);
    }

    /**
     * @api {delete} /api/cart/:purchase/remove Видалити продукт з кошика
     * @apiName RemoveFromCart
     * @apiGroup Cart
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} purchase ID покупки (path param)
     * @apiParam {Number} [qty=1] Кількість для видалення
     *
     * @apiSuccess {Boolean} success Статус операції
     * @apiSuccess {String} message Повідомлення
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "message": "Продукт видалено з корзини"
     * }
     */
    public function remove(Request $request, Purchase $purchase)
    {
        $qty = (int) $request->input('qty', 1);

        if ($qty > 0 && $purchase->quantity > $qty) {
            Cart::updatePurchase($purchase, $purchase->quantity - $qty);
        } else {
            Cart::removePurchase($purchase);
        }

        return response()->json([
            'success' => true,
            'message' => 'Продукт видалено з корзини',
        ]);
    }
    
    /**
     * @api {post} /api/cart/checkout Оформлення замовлення
     * @apiName Checkout
     * @apiGroup Cart
     * @apiVersion 1.0.0
     *
     * @apiParam {String} name Ім’я користувача
     * @apiParam {String} email Email користувача
     * @apiParam {String="online","cod"} payment_method Метод оплати (online/cod)
     * @apiParam {String} [phone] Телефон
     * @apiParam {String} [address] Адреса доставки
     *
     * @apiSuccess {Boolean} success Статус операції
     * @apiSuccess {String} message Повідомлення
     * @apiSuccess {Number} order_id ID замовлення
     * @apiSuccess {Number} payment_id ID платежу
     * @apiSuccess {String} [redirect_url] URL для редіректу (якщо online оплата
     *
     * @apiSuccessExample {json} Успішна відповідь (оплата при отриманні):
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "message": "Ваше замовлення успішно оформлено!",
     *   "order_id": 16,
     *   "payment_id": 45
     * }
     *
     * @apiErrorExample {json} Помилка (порожній кошик):
     * HTTP/1.1 400 Bad Request
     * {
     *   "success": false,
     *   "message": "Ваш кошик порожній."
     * }
     */
    public function checkout (CartRequest $request)
    {
        $cartId = Cookie::get('cart_id');
        if (!$cartId) {
            return response()->json([
                'success' => false,
                'message' => 'Ваш кошик порожній.',
            ], 400);
        }

        $order = Order::find($cartId);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Замовлення не знайдено.',
            ], 404);
        }

        $validated = $request->validated();

        $user = Auth::user();

        if (!$user) {
            $user = User::where('email', $validated['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make(Str::random(8)), 
                ]);
            }
        }

        $order->update([
            'user_id' => $user->id,
            'type' => 'order',
            'status' => 'pending',
            'user_info' => $validated,
        ]);

        $order->recalculateTotalPrice();

        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'total_price' => currency_convert($order->total_price, currency_active()),
            'currency' => currency_active(),
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'transaction_id' => null, 
        ]);

        if ($validated['payment_method'] === 'online') {
            $paymentUrl = route('payment.gateway', $order);

            return response()->json([
                'success' => true,
                'message' => 'Перенаправлення на сторінку оплати...',
                'redirect_url' => $paymentUrl,
                'order_id' => $order->id,
                'payment_id' => $payment->id,
            ]);
        } else {
            $order->update(['status' => 'processing']);
        }

        Cookie::queue(Cookie::forget('cart_id'));

        return response()->json([
            'success' => true,
            'message' => 'Ваше замовлення успішно оформлено!',
            'order_id' => $order->id,
            'payment_id' => $payment->id,
        ]);
    }
}
