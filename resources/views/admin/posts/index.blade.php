@extends('admin.layouts.app')

@section('content')
<section class="content">
        <div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Пости</h3>
            <div class="card-tools">
                <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm">+ Додати</a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Назва</th>
                        <th>Категорія</th>
                        <th>Користувач</th>
                        <th>slug</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->name }}</td>
                            <td>{{ $post->category->name ?? '—' }}</td>
                            <td>{{ $post->user->name ?? '—' }}</td>
                            <td>{{ $post->slug }}</td>
                            <td>
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Редагувати</a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Ви впевнені?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Видалити</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Постів знайдено.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
    </section>

@endsection