<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Resources\PageResource;
use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{

    /**
     * @api {get} /api/pages/:template Отримати сторінку за шаблоном
     * @apiName GetPage
     * @apiGroup Pages
     *
     * @apiParam {String} template Унікальний ключ шаблону сторінки.
     *
     * @apiSuccess {Number} id ID сторінки.
     * @apiSuccess {String} title Заголовок сторінки.
     * @apiSuccess {String} body Основний вміст сторінки.
     * @apiSuccess {String} template Назва шаблону.
     * @apiSuccess {String} slug SEO-slug сторінки.
     * @apiSuccess {String} created_at Дата створення.
     * @apiSuccess {String} updated_at Дата оновлення.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "data": {
     *       "id": 1,
     *       "name": "Про нас",
     *       "description": "Інформація про компанію.",
     *       "template": "about"
     *   },
     * }
     *
     * @apiError PageNotFound Сторінку з таким шаблоном не знайдено.
     *
     * @apiErrorExample {json} Помилка 404:
     * HTTP/1.1 404 Not Found
     * {
     *   "message": "No query results for model [App\\Models\\Page]"
     * }
     */
    public function show(string $template)
    {
        $page = Page::where('template', $template)->firstOrFail();
        return PageResource::make($page);
    }
}
