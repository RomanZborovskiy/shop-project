@extends('admin.layouts.app')

@section('content')
<section class="content">
        <div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Список властивостей</h3>
        </div>
        <div class="card-tools">                 
                    <a href="{{ route('properties.create') }}" class="btn btn-primary btn-sm">+ Додати</a>
                </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Назва</th>
                        <th>Атрибут</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($properties as $property)
                        <tr>
                            <td>{{ $property->id }}</td>
                            <td>{{ $property->value }}</td>
                            <td>{{ $property->attribute->name ?? '—' }}</td>
                            <td>
                               <a href="{{ route('properties.edit', $property) }}" class="btn btn-sm btn-warning">Редагувати</a>
                                    <form action="{{ route('properties.destroy', $property) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Ви впевнені?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Видалити</button>
                                    </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Властивостів не знайдено.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $properties->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
    </section>

@endsection
