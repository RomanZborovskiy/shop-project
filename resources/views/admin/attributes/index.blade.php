@extends('admin.layouts.app')

@section('content')
<section class="content">
        <div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Продукти</h3>
            <div class="card-tools">
                <a href="{{ route('attributes.create') }}" class="btn btn-primary btn-sm">+ Додати</a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Назва</th>
                        <th>Категорія</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attributes as $attribute)
                        <tr>
                            <td>{{ $attribute->id }}</td>
                            <td>{{ $attribute->name }}</td>
                            <td>{{ $attribute->category->name ?? '—'}}</td>
                            <td>
                                <a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-sm btn-warning">Редагувати</a>
                                <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Ви впевнені?')">
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
            {{ $attributes->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
    </section>

@endsection