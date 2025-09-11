<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * @api {get} /api/favorites Отримати список улюблених товарів
     * @apiName GetFavorites
     * @apiGroup Favorites
     * @apiVersion 1.0.0
     * @apiPermission Авторизація
     *
     * @apiSuccess {Object[]} products Список улюблених товарів
     * @apiSuccess {Number} products.id ID товару
     * @apiSuccess {String} products.name Назва товару
     * @apiSuccess {Number} products.price Ціна товару
     * @apiSuccess {String} products.slug Slug товару
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * [
     *   {
     *     "id": 1,
     *     "name": "Ноутбук ASUS",
     *     "price": 32000,
     *     "slug": "asus-notebook"
     *   },
     *   {
     *     "id": 2,
     *     "name": "Смартфон Samsung",
     *     "price": 15000,
     *     "slug": "samsung-phone"
     *   }
     * ]
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
        $products = auth()->user()->favoriteProducts()->paginate(20);

        return ProductResource::collection($products);
    }

    /**
     * @api {post} /api/favorites/{product}/toggle Додати/Видалити товар з улюблених
     * @apiName ToggleFavorite
     * @apiGroup Favorites
     * @apiVersion 1.0.0
     * @apiPermission Авторизація
     *
     * @apiParam {Number} product ID товару (в URL)
     *
     * @apiSuccess {Boolean} success Статус виконання
     * @apiSuccess {String} message Повідомлення
     *
     * @apiSuccessExample {json} Додано в улюблені:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "message": "Продук був доданий до улюблених"
     * }
     *
     * @apiSuccessExample {json} Видалено з улюблених:
     * HTTP/1.1 200 OK
     * {
     *   "success": true,
     *   "message": "Продук був видалений з улюблених"
     * }
     *
     * @apiError Unauthorized Користувач не авторизований
     * @apiErrorExample {json} Помилка 401:
     * HTTP/1.1 401 Unauthorized
     * {
     *   "success": false,
     *   "message": "Користувач не авторизований"
     * }
     */
    public function toggle(Product $product)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Користувач не авторизований',
            ], 401);
        }

        $favorite = Favorite::where('user_id', $user->id)
                ->where('product_id', $product->id)->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json([
                'success' => true,
                'message' => 'Продук був видалений з улюблених',
            ]);
        } else {
            Favorite::create([
                'user_id'    => $user->id,
                'product_id' => $product->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Продук був доданий до улюблених',
            ]);
        }
    }
}
