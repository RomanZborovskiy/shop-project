<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Cart, Product, Purchase, Order, Payment, User};
use Illuminate\Support\Facades\{Auth, Cookie, Hash};
use Illuminate\Support\Str;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    /**
     * @api {get} /api/cart Отримати корзину
     * @apiName GetCart
     * @apiGroup Cart
     * @apiVersion 1.0.0
     *
     * @apiSuccess {Number} id ID корзини
     * @apiSuccess {Number} total_price Загальна сума
     * @apiSuccess {Object[]} products Товари у корзині
     * @apiSuccess {Number} products.id ID товару
     * @apiSuccess {String} products.name Назва товару
     * @apiSuccess {Number} products.price Ціна товару
     * @apiSuccess {Number} products.quantity Кількість
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "id": 15,
     *   "total_price": 1200,
     *   "products": [
     *     {"id":1,"name":"Ноутбук","price":1200,"quantity":1}
     *   ]
     * }
     */
    public function index(Request $request)
    {
        $cart = Cart::getCart();
        return CartResource::make($cart);
    }

    /**
     * @api {post} /api/cart/{product}/add Додати товар у корзину
     * @apiName AddToCart
     * @apiGroup Cart
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} product ID товару (в URL)
     * @apiParam {Number} [qty=1] Кількість товару
     *
     * @apiSuccess {Boolean} success Статус
     * @apiSuccess {String} message Повідомлення
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "message": "Product added to cart"
     * }
     */
    public function add(Request $request, Product $product)
    {
        $qty = max((int) $request->input('qty', 1), 1);
        Cart::addProduct($product, $qty);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
        ]);
    }

    /**
     * @api {delete} /api/cart/{purchase}/remove Видалити товар з корзини
     * @apiName RemoveFromCart
     * @apiGroup Cart
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} purchase ID покупки (в URL)
     * @apiParam {Number} [qty=1] Кількість для видалення
     *
     * @apiSuccess {Boolean} success Статус
     * @apiSuccess {String} message Повідомлення
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "message": "Product removed from cart"
     * }
     */
    public function remove(Request $request, Purchase $purchase)
    {
        $qty = (int) $request->input('qty', 1);

        if ($qty > 0 && $purchase->quantity > $qty) {
            $purchase->update(['quantity' => $purchase->quantity - $qty]);
            $purchase->order->recalculateTotalPrice();
        } else {
            Cart::removePurchase($purchase);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
        ]);
    }

    /**
     * @api {post} /api/cart/checkout Оформлення замовлення
     * @apiName Checkout
     * @apiGroup Cart
     * @apiVersion 1.0.0
     *
     * @apiParam {String} name Ім'я користувача
     * @apiParam {String} email Email
     * @apiParam {String} phone Телефон
     * @apiParam {Number} [settlement_id] ID населеного пункту
     * @apiParam {String} delivery Спосіб доставки
     * @apiParam {String="cash_on_delivery","online"} payment_method Метод оплати
     *
     * @apiSuccess {Boolean} success Статус
     * @apiSuccess {String} message Повідомлення
     * @apiSuccess {Number} order_id ID замовлення
     * @apiSuccess {Number} payment_id ID платежу
     * @apiSuccess {String} [redirect_url] URL для онлайн-оплати (якщо `payment_method=online`)
     *
     * @apiSuccessExample {json} Успішна відповідь (онлайн оплата):
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "message": "Перенаправлення на сторінку оплати...",
     *   "redirect_url": "https://example.com/pay/123",
     *   "order_id": 10,
     *   "payment_id": 5
     * }
     *
     * @apiSuccessExample {json} Успішна відповідь (накладений платіж):
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "message": "Ваше замовлення успішно оформлено!",
     *   "order_id": 10,
     *   "payment_id": 5
     * }
     */
    public function checkout(Request $request)
    {
        // ... твій код checkout ...
    }
}
