


@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Категорії</h2>
    {!! Lte3::nestedset($categories, [
        'label' => 'Категорії',
        'has_nested' => $vocabulary['has_hierarchy'],
        'routes' => [
            'edit'   => \Illuminate\Support\Arr::get($vocabulary, 'permissions.update') === false ? null : 'admin.categories.edit',
            'create' => \Illuminate\Support\Arr::get($vocabulary, 'permissions.create') === false ? null : 'admin.categories.create',
            'delete' => \Illuminate\Support\Arr::get($vocabulary, 'permissions.delete') === false ? null : 'admin.categories.destroy',
            'order'  => \Illuminate\Support\Arr::get($vocabulary, 'permissions.update') === false ? null : 'admin.categories.order',
        ],
    ]) !!}
</div>
@endsection




{{-- @extends('admin.layouts.app')

@section('content')
<section class="content">
        <div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Продукти</h3>
            <div class="card-tools">
                <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">+ Додати</a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Назва</th>
                        <th>Тип</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->type }}</td>
                            <td>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Редагувати</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Ви впевнені?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Видалити</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Категорій не знайдено.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $categories->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
    </section>

@endsection --}}