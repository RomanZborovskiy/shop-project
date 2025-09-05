<?php

namespace App\Http\client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Fomvasss\Seo\Seo;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'user')->latest()->paginate(9);
        return view('client.posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->with('category', 'user')->where('slug', $post->slug)->firstOrFail();
        return view('client.posts.show',['model' => $post], compact('post'));
    }
}
