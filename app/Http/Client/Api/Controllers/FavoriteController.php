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

    public function toggleProduct(Product $product)
    {
        $added = Favorite::toggle($product);

        return response()->json([
            'status'  => 'success',
            'message' => $added ? 'Товар додано до обраних' : 'Товар видалено з обраних',
        ]);
    }

    public function products()
    {
        $products = FavoriteModel::where('user_id', auth()->id())
            ->where('model_type', Product::class)
            ->with('model')
            ->paginate(12)
            ->through(fn ($favorite) => $favorite->model);

        return ProductResource::collection($products);
    }

    public function togglePost(Post $post)
    {
        $added = Favorite::toggle($post);

        return response()->json([
            'status'  => 'success',
            'message' => $added ? 'Статтю додано до обраних' : 'Статтю видалено з обраних',
        ]);
    }

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