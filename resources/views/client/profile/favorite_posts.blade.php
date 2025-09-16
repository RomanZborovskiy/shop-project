@extends('client.layouts.app')

@section('title', 'Мої обрані')

@section('content')
<div class="container py-5">
    <h1>Мої обрані статті</h1>
    <div class="row">
        @forelse($posts as $post)
            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>
                            <a href="{{ route('client.posts.show', $post) }}">
                                {{ $post->name }}
                            </a>
                        </h5>

                        <form method="POST" action="{{ route('client.favorites.post', $post) }}">
                        @csrf
                        <button class="btn btn-sm {{ \App\Facades\Favorite::isFavorite($post) ? 'btn-outline-danger' : 'btn-outline-success' }}" type="submit">
                            {{ \App\Facades\Favorite::isFavorite($post) ? 'Видалити з обраних' : 'Додати в обрані' }}
                        </button>
                    </form>
                    </div>
                </div>
            </div>
        @empty
            <p>Немає обраних постів</p>
        @endforelse
    </div>

    {{ $posts->links() }}
</div>
@endsection
