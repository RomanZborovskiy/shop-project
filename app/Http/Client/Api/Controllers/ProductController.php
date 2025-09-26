<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @api {get} /api/products Отримати список товарів
     * @apiName GetProducts
     * @apiGroup Products
     * @apiVersion 1.0.0
     *
     * @apiDescription Повертає список товарів з брендом та категорією. 
     * Є підтримка фільтрації (через query-параметри) та пагінації (по 12 товарів).
     *
     * @apiParam {Number} [page=1] Номер сторінки
     * @apiParam {String} [brand] Фільтр за брендом
     * @apiParam {String} [category] Фільтр за категорією
     *
     * @apiSuccess {Object[]} data Список товарів
     * @apiSuccess {Number} data.id ID товару
     * @apiSuccess {String} data.name Назва товару
     * @apiSuccess {String} data.description Опис товару
     * @apiSuccess {Number} data.price Ціна товару
     * @apiSuccess {Object} data.brand Бренд товару
     * @apiSuccess {Number} data.brand.id ID бренду
     * @apiSuccess {String} data.brand.name Назва бренду
     * @apiSuccess {Object} data.category Категорія товару
     * @apiSuccess {Number} data.category.id ID категорії
     * @apiSuccess {String} data.category.name Назва категорії
     * @apiSuccess {String} data.created_at Дата створення
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *   "data": [
     *       {
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
     *       },
     *       {
     *           "id": 2,
     *           "name": "Soluta non molestiae",
     *           "description": null,
     *           "price": "493.00",
     *           "old_price": "503.65",
     *           "quantity": 89,
     *           "status": "pending",
     *           "sku": "TS3ALKWLDY",
     *           "slug": "soluta-non-molestiae",
     *           "brand": "Hermiston LLC",
     *           "category": "Washer"
     *       },
     *   ],
     *   "links": {...},
     *   "meta": {...}
     * }
     */
    public function index(Request $request)
    {
        $products = Product::with(['brand', 'category'])->filter($request->all())->paginate(12);

        return ProductResource::collection($products);
    }

    /**
     * @api {get} /api/products/:id Отримати товар
     * @apiName GetProduct
     * @apiGroup Products
     * @apiVersion 1.0.0
     *
     * @apiDescription Повертає інформацію про конкретний товар.
     *
     * @apiParam {Number} id ID товару
     *
     * @apiSuccess {Number} id ID товару
     * @apiSuccess {String} name Назва товару
     * @apiSuccess {String} description Опис товару
     * @apiSuccess {Number} price Ціна товару
     * @apiSuccess {Object} brand Бренд товару
     * @apiSuccess {Object} category Категорія товару
     * @apiSuccess {String} created_at Дата створення
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * {
     *    "data": {
     *      "id": 1,
     *      "name": "Veniam et inventore",
     *       "description": null,
     *       "price": "88.64",
     *       "old_price": null,
     *       "quantity": 73,
     *       "status": "pending",
     *       "sku": "TYYRTLIKJG",
     *       "slug": "veniam-et-inventore",
     *       "brand": "Jaskolski, Romaguera and Johnston",
     *       "category": "Shampoos"
     *   },
     * }
     *
     * @apiError NotFound Товар не знайдено
     * @apiErrorExample {json} Помилка 404:
     * HTTP/1.1 404 Not Found
     * {
     *   "message": "Product not found"
     * }
     */
    public function show(string $product)
    {
        $product = Product::where('id', $product)->with(['brand', 'category'])->firstOrFail();
        return ProductResource::make($product);
    }
}
