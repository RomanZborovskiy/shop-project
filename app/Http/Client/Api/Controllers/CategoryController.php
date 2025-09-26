<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Resources\CategoryResource;
use App\Http\Controllers\Controller;
use App\Models\Term;

class CategoryController extends Controller
{
    /**
     * @api {get} /api/categories Отримати список категорій
     * @apiName GetCategories
     * @apiGroup Categories
     * @apiVersion 1.0.0
     *
     * @apiSuccess {Object[]} categories Список категорій
     * @apiSuccess {Number} categories.id ID категорії
     * @apiSuccess {String} categories.name Назва категорії
     * @apiSuccess {String} categories.slug Слаг (URL-ідентифікатор)
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * [
     *   "data": [
     *   {
     *      "id": 1,
     *       "name": "Electronics",
     *        "parent_id": null,
     *        "vocabulary": "categories",
     *       "slug": "electronics"
     *   },
     *   {
     *       "id": 2,
     *       "name": "Alarms",
     *      "parent_id": 1,
     *       "vocabulary": "categories",
     *       "slug": "alarms"
     *   },
     * ]
     */

    public function index()
    {
        $categories = Term::all();
        return CategoryResource::collection($categories);
    }

    /**
     * @api {get} /api/categories/1 Отримати категорію
     * @apiName GetCategory
     * @apiGroup Categories
     * @apiVersion 1.0.0
     *
     * @apiParam {String} slug Унікальний slug категорії
     *
     * @apiSuccess {Number} id ID категорії
     * @apiSuccess {String} name Назва категорії
     * @apiSuccess {String} slug Slug категорії
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * "data": {
     *   "id": 1,
     *   "name": "Electronics",
     *   "parent_id": null,
     *   "vocabulary": "categories",
     *   "slug": "electronics"
     *  }
     *
     * @apiError CategoryNotFound Категорію не знайдено.
     * @apiErrorExample {json} Помилка 404:
     * HTTP/1.1 404 Not Found
     * {
     *   ""message": "No query results for model [App\\Models\\Term].",
     * }
     */
    public function show(string $category)
    {
        $category = Term::where('id', $category)->firstOrFail();
        return CategoryResource::make($category);
    }
}
