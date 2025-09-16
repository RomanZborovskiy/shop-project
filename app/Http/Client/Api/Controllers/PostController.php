<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Resources\PostResource;
use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'user'])
            ->latest()
            ->paginate(12);

        return PostResource::collection($posts);
    }

    public function show(Post $post)
    {
        $post->load(['category', 'user']);

        return PostResource::make($post);
    }
}
