@extends('client.layouts.app')

@section('title', 'Пости')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">Всі пости</h2>

    @if($posts->isEmpty())
        <p class="text-muted">Постів поки що немає.</p>
    @else
        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $post->name }}</h5>
                            <p class="card-text text-muted">
                                {{ Str::limit($post->description, 100) }}
                            </p>

                            <p class="small text-secondary mt-auto">
                                Категорія: {{ $post->category?->name ?? '—' }} <br>
                                Автор: {{ $post->user?->name ?? '—' }}
                            </p>

                            <a href="{{ route('client.posts.show', $post->slug) }}" class="btn btn-primary">
                                <i class="bi bi-eye"></i> Читати далі
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
