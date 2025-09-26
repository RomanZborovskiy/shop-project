<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Resources\PostResource;
use App\Http\Client\Api\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Facades\Favorite;
use App\Models\Post;
use App\Models\Product;
use App\Models\Favorite as FavoriteModel;

class FavoriteController extends Controller
{

    /**
     * @api {post} /api/products/:id/favorite Перемкнути товар в обраному
     * @apiName ToggleFavoriteProduct
     * @apiGroup Favorites
     * @apiVersion 1.0.0
     * @apiPermission Авторизація
     *
     * @apiDescription Додає товар до обраних або видаляє, якщо він там уже є.
     *
     * @apiParam {Number} id ID товару
     *
     * @apiSuccess {String} status Статус відповіді
     * @apiSuccess {String} message Повідомлення
     *
     * @apiSuccessExample {json} Додано:
     * HTTP/1.1 200 OK
     * {
     *   "status": "success",
     *   "message": "Товар додано до обраних"
     * }
     *
     * @apiSuccessExample {json} Видалено:
     * HTTP/1.1 200 OK
     * {
     *   "status": "success",
     *   "message": "Товар видалено з обраних"
     * }
     *
     * @apiError Unauthorized Користувач не авторизований
     * @apiErrorExample {json} Помилка 401:
     * HTTP/1.1 401 Unauthorized
     * {
     *   "message": "Unauthenticated."
     * }
     */
    public function toggleProduct(Product $product)
    {
        $added = Favorite::toggle($product);

        return response()->json([
            'status'  => 'success',
            'message' => $added ? 'Товар додано до обраних' : 'Товар видалено з обраних',
        ]);
    }

    /**
     * @api {get} /api/my/products Отримати список обраних товарів
     * @apiName GetFavoriteProducts
     * @apiGroup Favorites
     * @apiVersion 1.0.0
     * @apiPermission Авторизація
     *
     * @apiDescription Повертає список товарів, доданих до обраних користувачем.
     *
     * @apiParam {Number} [page=1] Номер сторінки (12 товарів на сторінку)
     *
     * @apiSuccess {Object[]} products Список товарів
     * @apiSuccess {Number} products.id ID товару
     * @apiSuccess {String} products.name Назва товару
     * @apiSuccess {Number} products.price Ціна товару
     * @apiSuccess {String} products.slug Slug товару
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *    "data": [
     *      {
     *           "id": 1,
     *           "name": "Veniam et inventore",
     *           "description": null,
     *           "price": "88.64",
     *           "old_price": null,
     *           "quantity": 73,
     *           "status": "pending",
     *           "sku": "TYYRTLIKJG",
     *           "slug": "veniam-et-inventore",
     *           "brand": "Jaskolski, Romaguera and Johnston",
     *           "category": "Shampoos"
     *       }
     *   ],
     *   "links": {...},
     *   "meta": {...}
     * }
     */
    public function products()
    {
        $products = FavoriteModel::where('user_id', auth()->id())
            ->where('model_type', Product::class)
            ->with('model')
            ->paginate(12)
            ->through(fn ($favorite) => $favorite->model);

        return ProductResource::collection($products);
    }

    /**
     * @api {post} /api/posts/:id/favorite Перемкнути статтю в обраному
     * @apiName ToggleFavoritePost
     * @apiGroup Favorites
     * @apiVersion 1.0.0
     * @apiPermission Авторизація
     *
     * @apiDescription Додає статтю до обраних або видаляє, якщо вона там уже є.
     *
     * @apiParam {Number} id ID статті
     *
     * @apiSuccess {String} status Статус відповіді
     * @apiSuccess {String} message Повідомлення
     *
     * @apiSuccessExample {json} Додано:
     * HTTP/1.1 200 OK
     * {
     *   "status": "success",
     *   "message": "Статтю додано до обраних"
     * }
     *
     * @apiSuccessExample {json} Видалено:
     * HTTP/1.1 200 OK
     * {
     *   "status": "success",
     *   "message": "Статтю видалено з обраних"
     * }
     *
     * @apiError Unauthorized Користувач не авторизований
     * @apiErrorExample {json} Помилка 401:
     * HTTP/1.1 401 Unauthorized
     * {
     *   "message": "Unauthenticated."
     * }
     */
    public function togglePost(Post $post)
    {
        $added = Favorite::toggle($post);

        return response()->json([
            'status'  => 'success',
            'message' => $added ? 'Статтю додано до обраних' : 'Статтю видалено з обраних',
        ]);
    }

    /**
     * @api {get} /api/favorites/posts Отримати список обраних статей
     * @apiName GetFavoritePosts
     * @apiGroup Favorites
     * @apiVersion 1.0.0
     * @apiPermission Авторизація
     *
     * @apiDescription Повертає список статей, доданих до обраних користувачем.
     *
     * @apiParam {Number} [page=1] Номер сторінки (12 статей на сторінку)
     *
     * @apiSuccess {Object[]} posts Список статей
     * @apiSuccess {Number} posts.id ID статті
     * @apiSuccess {String} posts.title Заголовок
     * @apiSuccess {String} posts.slug Slug статті
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "data": [
     *       {
     *           "id": 1,
     *           "name": "Aperiam illo optio.",
     *           "description": null,
     *           "text": "In in optio facere. Odit et iure officiis omnis non aspernatur. Asperiores ab architecto sit praesentium. Dicta dolor molestiae odio atque quia.\n\nAlias aut ratione tempora tempora omnis necessitatibus aperiam. Nesciunt voluptas cum illum qui velit qui. Doloremque qui qui inventore aut blanditiis ratione.\n\nAliquid consequatur adipisci laudantium quam accusantium aut. At magni ab rem molestiae qui. Veritatis ratione sequi est est.",
     *           "tags": [],
     *           "slug": "aperiam-illo-optio",
     *           "category": "Wheels and rims",
     *           "user": "Dr. Miguel Kulas V"
     *       }
     *   ],
     *   "links": {...},
     *   "meta": {...}
     * }
     */
    public function posts()
    {
        $posts = FavoriteModel::where('user_id', auth()->id())
            ->where('model_type', Post::class)
            ->with('model')
            ->paginate(12)
            ->through(fn ($favorite) => $favorite->model);

        return PostResource::collection($posts);
    }
}