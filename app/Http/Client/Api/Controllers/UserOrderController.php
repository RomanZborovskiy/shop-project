<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    /**
     * @api {get} /api/my/orders Отримати список замовлень користувача
     * @apiName GetUserOrders
     * @apiGroup Orders
     * @apiVersion 1.0.0
     * @apiPermission Авторизація
     *
     * @apiDescription Повертає список замовлень авторизованого користувача.
     *
     * @apiParam {Number} [page=1] Номер сторінки (пагінація, 10 замовлень на сторінку)
     *
     * @apiSuccess {Boolean} success Статус виконання
     * @apiSuccess {Object[]} orders Список замовлень
     * @apiSuccess {Number} orders.id ID замовлення
     * @apiSuccess {Number} orders.user_id ID користувача
     * @apiSuccess {String} orders.status Статус замовлення
     * @apiSuccess {Number} orders.total Загальна сума
     * @apiSuccess {Object[]} orders.purchases Придбані товари
     * @apiSuccess {Number} orders.purchases.id ID покупки
     * @apiSuccess {Number} orders.purchases.quantity Кількість
     * @apiSuccess {Number} orders.purchases.price Ціна за одиницю
     * @apiSuccess {Object} orders.purchases.product Інформація про товар
     * @apiSuccess {Number} orders.purchases.product.id ID товару
     * @apiSuccess {String} orders.purchases.product.name Назва товару
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "orders": {
     *      "current_page": 1,
     *      "data": [
     *           {
     *               "id": 8,
     *               "total_price": "808.34",
     *               "status": "cancelled",
     *               "type": null,
     *               "user_info": {
     *                   "name": "Mabel Greenfelder IV",
     *                   "email": "goyette.maegan@example.com",
     *                   "phone": "860.229.1149",
     *                   "address": "899 Bauch Bypass Apt. 004\nLake Winstonfurt, AR 41570"
     *               },
     *               "user_id": 1,
     *               "created_at": "2025-09-25T09:46:45.000000Z",
     *               "updated_at": "2025-09-25T09:46:45.000000Z",
     *               "purchases": [
     *                  {
     *                      "id": 2,
     *                       "price": "804.08",
     *                       "quantity": 4,
     *                       "product_id": 9,
     *                       "order_id": 8,
     *                       "created_at": "2025-09-25T09:46:45.000000Z",
     *                       "updated_at": "2025-09-25T09:46:45.000000Z",
     *                       "product": {
     *                           "id": 9,
     *                           "name": "Quis ratione nesciunt",
     *                           "description": null,
     *                           "price": "201.02",
     *                           "old_price": null,
     *                           "quantity": 9,
     *                           "status": "pending",
     *                           "sku": "MBVR5Z1RFW",
     *                           "slug": "quis-ratione-nesciunt",
     *                           "brand_id": 1,
     *                           "category_id": 2,
     *                           "created_at": "2025-09-25T09:46:39.000000Z",
     *                           "updated_at": "2025-09-25T09:46:39.000000Z"
     *                       }
     *                   }      
     *             }
     *           }
     *         ]
     *       }
     *     ],
     *     "last_page": 3,
     *     "per_page": 10,
     *     "total": 25
     *   }
     * }
     *
     * @apiError Unauthorized Користувач не авторизований
     * @apiErrorExample {json} Помилка 401:
     * HTTP/1.1 401 Unauthorized
     * {
     *   "message": "Unauthenticated."
     * }
     */

    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with('purchases.product')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }

    // public function show(Order $order)
    // {
    //     if ($order->user_id !== Auth::id()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Доступ заборонено',
    //         ], 403);
    //     }

    //     $order->load('purchases.product', 'user');

    //     return response()->json([
    //         'success' => true,
    //         'order' => $order,
    //     ]);
    // }
}
