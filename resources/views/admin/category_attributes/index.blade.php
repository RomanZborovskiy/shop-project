@extends('admin.layouts.app')

@section('content')
<section class="content">
        <div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Список категорій</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Назва</th>
                        <th>Slug</th>
                        <th>Атрибути</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if($category->attributes->isNotEmpty())
                                    {{ $category->attributes->pluck('name')->join(', ') }}
                                @else
                                    <em>Немає</em>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('categories.attributes.edit', $category->id) }}" 
                                class="btn btn-sm btn-primary">
                                Редагувати атрибути
                                </a>
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
    </div>
</div>
    </section>

@endsection
