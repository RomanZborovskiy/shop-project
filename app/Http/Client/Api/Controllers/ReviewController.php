<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Requests\ReviewRequest;
use App\Http\Client\Api\Resources\ReviewResource;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * @api {get} /api/products/:id/reviews Отримати відгуки про товар
     * @apiName GetProductReviews
     * @apiGroup Reviews
     * @apiVersion 1.0.0
     *
     * @apiDescription Повертає список відгуків для конкретного товару.
     *
     * @apiParam {Number} id ID товару
     *
     * @apiSuccess {Object[]} data Список відгуків
     * @apiSuccess {Number} data.id ID відгуку
     * @apiSuccess {Number} data.rating Рейтинг (1–5)
     * @apiSuccess {String} data.comment Текст відгуку
     * @apiSuccess {Number} data.parent_id ID батьківського відгуку (якщо це відповідь)
     * @apiSuccess {String} data.status Статус відгуку (наприклад: "pending", "approved")
     * @apiSuccess {Object} data.user Автор відгуку
     * @apiSuccess {Number} data.user.id ID користувача
     * @apiSuccess {String} data.user.name Ім’я користувача
     * @apiSuccess {String} data.created_at Дата створення
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "data": [
     *          {
     *              "id": 8,
     *               "content": null,
     *               "rating": 3,
     *               "status": "approved",
     *               "user_id": 7,
     *               "product_id": 3,
     *               "parent_id": null
     *           }
     *   ]
     * }
     */

    public function index(Product $product)
    {
        $reviews = $product->reviews()->get();

        return ReviewResource::collection($reviews);
    }

    /**
     * @api {post} /api/products/:id/review Додати відгук про товар
     * @apiName AddReview
     * @apiGroup Reviews
     * @apiVersion 1.0.0
     * @apiPermission Авторизація
     *
     * @apiDescription Додає новий відгук до товару. Всі нові відгуки отримують статус "pending".
     *
     * @apiParam {Number} id ID товару
     *
     * @apiBody {Number{1-5}} rating Рейтинг (обов’язково, від 1 до 5)
     * @apiBody {String} comment Текст відгуку
     * @apiBody {Number} [parent_id] ID батьківського відгуку (якщо це відповідь на інший відгук)
     *
     * @apiSuccess {Object} data Новий відгук
     * @apiSuccess {Number} data.id ID відгуку
     * @apiSuccess {Number} data.rating Рейтинг
     * @apiSuccess {String} data.comment Текст відгуку
     * @apiSuccess {Number} data.parent_id ID батьківського відгуку
     * @apiSuccess {String} data.status Статус відгуку ("pending")
     * @apiSuccess {Object} data.user Автор відгуку
     * @apiSuccess {Number} data.user.id ID користувача
     * @apiSuccess {String} data.user.name Ім’я користувача
     * @apiSuccess {String} data.created_at Дата створення
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 201 Created
     * {
     *   "data": {
     *     "id": 12,
     *        "comment": null,
     *      "rating": 3,
     *      "status": "pending",
     *       "user_id": 11,
     *       "product_id": 3,
     *       "parent_id": null
     *   },
     * }
     *
     * @apiError Unauthorized Користувач не авторизований
     * @apiErrorExample {json} Помилка 401:
     * HTTP/1.1 401 Unauthorized
     * {
     *   "message": "Unauthenticated."
     * }
     *
     * @apiError ValidationError Помилка валідації
     * @apiErrorExample {json} Помилка 422:
     * HTTP/1.1 422 Unprocessable Entity
     * {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *     "rating": ["Поле rating є обов’язковим."]
     *   }
     * }
     */
    public function store(ReviewRequest $request, Product $product)
    {
        $validated = $request->validated();

        $review = Review::create([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'parent_id' => $validated['parent_id'],
            'status' => 'pending',
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        return ReviewResource::make($review);
    }
}
