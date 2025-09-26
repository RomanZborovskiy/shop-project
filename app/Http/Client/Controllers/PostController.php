<?php

namespace App\Http\Client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'user')->latest()->paginate(9);
        return view('client.posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->load(['category', 'user']);

        return view('client.posts.show', compact('post'));
    }
}
