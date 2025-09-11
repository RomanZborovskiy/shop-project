<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $products = auth()->user()->favoriteProducts()->paginate(20);

        return ProductResource::collection($products);
    }
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
