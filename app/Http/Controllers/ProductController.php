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
     * @apiParam {Number} [page=1] Номер сторінки пагінації
     * @apiParam {Number} [per_page=12] Кількість товарів на сторінці
     * @apiParam {String} [name] Фільтр за назвою
     * @apiParam {Number} [price_from] Мінімальна ціна
     * @apiParam {Number} [price_to] Максимальна ціна
     * @apiParam {Number} [brand_id] ID бренду
     * @apiParam {Number} [category_id] ID категорії
     *
     * @apiSuccess {Object[]} products Список товарів
     * @apiSuccess {Number} products.id ID товару
     * @apiSuccess {String} products.name Назва товару
     * @apiSuccess {String} products.slug Slug товару
     * @apiSuccess {Number} products.price Ціна
     * @apiSuccess {Object} products.brand Бренд
     * @apiSuccess {String} products.brand.name Назва бренду
     * @apiSuccess {Object} products.category Категорія
     * @apiSuccess {String} products.category.name Назва категорії
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * [
     *   [
     *  {
     *      "id": 2,
     *       "name": "Unde corporis molestias",
     *       "description": "Impedit laborum mollitia nihil atque nostrum. Placeat quibusdam aut cupiditate corporis magnam. Saepe vero iure accusamus aut esse repellendus.",
     *       "price": "955.49",
     *       "old_price": null,
     *       "quantity": 93,
     *       "status": "pending",
    *      "sku": "SDBKB8KEVL",
     *       "slug": "unde-corporis-molestias",
      *      "brand": "Kiehn-Lebsack",
       *     "category": "Electronics"
       * }
     * ]
     */
    public function index(Request $request)
    {
        $products = Product::with(['brand', 'category'])
            ->filter($request->all())
            ->paginate(12);

        return ProductResource::collection($products);
    }

    /**
     * @api {get} /api/products/:slug Отримати товар по slug
     * @apiName GetProduct
     * @apiGroup Products
     * @apiVersion 1.0.0
     *
     * @apiParam {String} slug Унікальний slug товару
     *
     * @apiSuccess {Number} id ID товару
     * @apiSuccess {String} name Назва товару
     * @apiSuccess {String} slug Slug
     * @apiSuccess {Number} price Ціна
     * @apiSuccess {Object} brand Бренд
     * @apiSuccess {String} brand.name Назва бренду
     * @apiSuccess {Object} category Категорія
     * @apiSuccess {String} category.name Назва категорії
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
      *  {
     *      "id": 2,
     *       "name": "Unde corporis molestias",
     *       "description": "Impedit laborum mollitia nihil atque nostrum. Placeat quibusdam aut cupiditate corporis magnam. Saepe vero iure accusamus aut esse repellendus.",
     *       "price": "955.49",
     *       "old_price": null,
     *       "quantity": 93,
     *       "status": "pending",
    *      "sku": "SDBKB8KEVL",
     *       "slug": "unde-corporis-molestias",
      *      "brand": "Kiehn-Lebsack",
       *     "category": "Electronics"
       * }
     *
     * @apiError ProductNotFound Товар не знайдено
     * @apiErrorExample {json} Помилка 404:
     * HTTP/1.1 404 Not Found
     * {
     *   "message": "No query results for model [Product]"
     * }
     */
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['brand', 'category'])
            ->firstOrFail();

        return ProductResource::make($product);
    }

    /**
     * @api {get} /api/products/search Пошук товарів
     * @apiName SearchProducts
     * @apiGroup Products
     * @apiVersion 1.0.0
     *
     * @apiParam {String} q Пошуковий запит
     * @apiParam {Number} [page=1] Номер сторінки пагінації
     * @apiParam {Number} [per_page=12] Кількість товарів на сторінці
     *
     * @apiSuccess {Object[]} products Список знайдених товарів
     * @apiSuccess {Number} products.id ID товару
     * @apiSuccess {String} products.name Назва товару
     * @apiSuccess {String} products.slug Slug
     * @apiSuccess {Number} products.price Ціна
     *
     * @apiSuccessExample {json} Успішна відповідь:
     * HTTP/1.1 200 OK
     * [
      *  {
     *      "id": 2,
     *       "name": "Unde corporis molestias",
     *       "description": "Impedit laborum mollitia nihil atque nostrum. Placeat quibusdam aut cupiditate corporis magnam. Saepe vero iure accusamus aut esse repellendus.",
     *       "price": "955.49",
     *       "old_price": null,
     *       "quantity": 93,
     *       "status": "pending",
    *      "sku": "SDBKB8KEVL",
     *       "slug": "unde-corporis-molestias",
      *      "brand": "Kiehn-Lebsack",
       *     "category": "Electronics"
       * }
     * ]
     */
    public function search(Request $request)
    {
        $q = $request->input('q');

        $products = Product::where('name', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->with(['brand', 'category'])
            ->paginate(12);

        return ProductResource::collection($products);
    }
}
