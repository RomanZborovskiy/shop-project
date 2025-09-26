<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Resources\PostResource;
use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * @api {get} /api/posts Отримати список постів
     * @apiName GetPosts
     * @apiGroup Posts
     * @apiVersion 1.0.0
     * 
     * @apiDescription Повертає список постів з пагінацією. 
     * Кожен пост містить дані про категорію та користувача (автора).
     *
     * @apiParam {Number} [page=1] Номер сторінки (пагінація)
     *
     * @apiSuccess {Object[]} data Список постів
     * @apiSuccess {Number} data.id ID поста
     * @apiSuccess {String} data.title Заголовок поста
     * @apiSuccess {String} data.content Текст поста
     * @apiSuccess {Object} data.category Категорія поста
     * @apiSuccess {Number} data.category.id ID категорії
     * @apiSuccess {String} data.category.name Назва категорії
     * @apiSuccess {Object} data.user Автор поста
     * @apiSuccess {Number} data.user.id ID автора
     * @apiSuccess {String} data.user.name Ім’я автора
     * @apiSuccess {String} data.created_at Дата створення
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "data": [
     *   {
     *       "id": 1,
     *       "name": "Aperiam illo optio.",
     *       "description": null,
     *       "text": "In in optio facere. Odit et iure officiis omnis non aspernatur. Asperiores ab architecto sit praesentium. Dicta dolor molestiae odio atque quia.\n\nAlias aut ratione tempora tempora omnis necessitatibus aperiam. Nesciunt voluptas cum illum qui velit qui. Doloremque qui qui inventore aut blanditiis ratione.\n\nAliquid consequatur adipisci laudantium quam accusantium aut. At magni ab rem molestiae qui. Veritatis ratione sequi est est.",
     *       "tags": [],
     *       "slug": "aperiam-illo-optio",
     *       "category": "Wheels and rims",
     *       "user": "Dr. Miguel Kulas V"
     *   },
     *   {
     *       "id": 2,
     *       "name": "Delectus non molestias incidunt.",
     *       "description": "Temporibus nemo ab molestiae eum iusto voluptatem minima et dolor.",
     *       "text": "Voluptatibus magni ullam voluptatum voluptatem ipsum aut. Qui dignissimos vero modi voluptas vero. Culpa repellat eos nobis facilis ut.\n\nRepellat harum a illum velit natus. Magnam culpa provident sit blanditiis magni soluta corrupti. Nisi corporis quisquam dolorum sit.\n\nUllam sunt suscipit deserunt dolor accusamus omnis quidem incidunt. Quisquam placeat delectus molestiae vel ratione quidem maxime facere. Odio nostrum provident error.",
     *       "tags": [
     *           "autem dignissimos accusamus"
     *       ],
     *       "slug": "delectus-non-molestias-incidunt",
    *      "category": "Polishes",
     *       "user": "Ila Treutel"
     *   },
     * }
     */
    public function index()
    {
        $posts = Post::with(['category', 'user'])
            ->latest()
            ->paginate(12);

        return PostResource::collection($posts);
    }

    /**
     * @api {get} /api/posts/:id Отримати один пост
     * @apiName GetPost
     * @apiGroup Posts
     * @apiVersion 1.0.0
     *
     * @apiDescription Повертає детальну інформацію про конкретний пост.
     *
     * @apiParam {Number} id ID поста
     *
     * @apiSuccess {Number} id ID поста
     * @apiSuccess {String} title Заголовок поста
     * @apiSuccess {String} content Текст поста
     * @apiSuccess {Object} category Категорія поста
     * @apiSuccess {Number} category.id ID категорії
     * @apiSuccess {String} category.name Назва категорії
     * @apiSuccess {Object} user Автор поста
     * @apiSuccess {Number} user.id ID автора
     * @apiSuccess {String} user.name Ім’я автора
     * @apiSuccess {String} created_at Дата створення
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "data": {
     *   "id": 5,
     *       "name": "Quibusdam animi.",
     *       "description": "Mollitia nostrum inventore qui ducimus corrupti laborum maxime ut corporis minus.",
     *       "text": "Est voluptas qui perferendis sed dolore vel earum. Excepturi vitae sint quis facere.\n\nNon nostrum in excepturi nobis. Quam vitae quia beatae provident amet ipsa delectus. Ad tempore est consequatur similique aliquid quisquam. Sit repellendus hic sed est qui est.\n\nDolorum tenetur dolorem ea velit assumenda quas sint. A optio labore ipsum et maxime recusandae inventore dolor. Iste dolorem doloremque sit voluptas porro aperiam enim. Nisi similique repudiandae nemo.",
     *       "tags": [],
     *       "slug": "quibusdam-animi",
     *       "category": "Polishes",
     *       "user": "Robb Wolff Sr."
     *   },
     * }
     *
     * @apiError NotFound Пост не знайдено
     * @apiErrorExample {json} Помилка 404:
     * HTTP/1.1 404 Not Found
     * {
     *   "message": "No query results for model [App\\Models\\Post] 55",
     * }
     */
    public function show(Post $post)
    {
        $post->load(['category', 'user']);

        return PostResource::make($post);
    }
}
