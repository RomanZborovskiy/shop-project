<?php

namespace App\Http\admin\Controllers;

use App\Http\admin\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Term;
use Illuminate\Support\Facades\Auth;
use App\Actions\SaveSeoAction;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category'])->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create(Post $post)
    {
        $categories = Term::where('vocabulary', 'categories');

        return view('admin.posts.create', compact( 'categories'));
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id(); 
        $post = Post::create($data);

        SaveSeoAction::run($post, $data['seo'] ?? []);

        return redirect()->route('posts.index')->with('success', 'Пост успішно створено!');
    }

    public function edit(Post $post)
    {
        $categories = Term::where('vocabulary', 'categories');

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(PostRequest $request, Post $post, SaveSeoAction $saveSeo)  
    {
        $data = $request->validated();

        $post::findOrFail($post->id)->update($data);

        SaveSeoAction::run($post, $data['seo'] ?? []);

        return redirect()->route('posts.edit')->with('success', 'Пост успішно оновлено!');
    
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success','Продукти видалено');
    }
}
