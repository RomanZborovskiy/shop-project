<?php

namespace App\Http\client\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Favorite;
use App\Models\Post;
use App\Models\Product;
use App\Models\Favorite as FavoriteModel;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function product(Product $product)
    {
        $added = Favorite::toggle($product);

        return redirect()
            ->back()
            ->with('success', $added ? 'Товар додано до обраних' : 'Товар видалено з обраних');
    }

    public function products()
    {
        $products = FavoriteModel::where('user_id', auth()->id())
            ->where('model_type', Product::class)
            ->with('model')
            ->paginate(12) 
            ->through(fn ($favorite) => $favorite->model); 

        return view('client.profile.favorite_products', compact('products'));
    }

    public function post(Post $post)
    {
        $added = Favorite::toggle($post);

        return redirect()
            ->back()
            ->with('success', $added ? 'Статтю додано до обраних' : 'Статтю видалено з обраних');
    }

    public function posts()
    {
        $posts = FavoriteModel::where('user_id', auth()->id())
            ->where('model_type', Post::class)
            ->with('model')
            ->paginate(12) 
            ->through(fn ($favorite) => $favorite->model); 

        return view('client.profile.favorite_posts', compact('posts'));
    }
}
