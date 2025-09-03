@extends('client.layouts.app')

@section('title', $post->name)

@section('content')
<div class="container my-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <h2 class="mb-3">{{ $post->name }}</h2>
            <p class="text-muted">
                Категорія: {{ $post->category?->name ?? '—' }} |
                Автор: {{ $post->user?->name ?? '—' }} |
                {{ $post->created_at->format('d.m.Y H:i') }}
            </p>

            @if($post->description)
                <p class="lead">{{ $post->description }}</p>
            @endif

            <div class="mt-3">
                {!! nl2br(e($post->text)) !!}
            </div>

            @if($post->tags)
                <div class="mt-4">
                    <h6>Теги:</h6>
                    <p>{{$post->tags}}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('client.posts.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Назад до всіх постів
        </a>
    </div>
</div>
@endsection
