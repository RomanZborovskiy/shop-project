@extends('layouts.adminlte')

@section('title', 'Додати продукт')

@section('content')
<div class="container mt-4">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Новий продукт</h3>
        </div>

        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label for="name">Назва</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Опис</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="price">Ціна</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
                </div>

                <div class="form-group">
                    <label for="old_price">Стара ціна</label>
                    <input type="number" step="0.01" name="old_price" class="form-control" value="{{ old('old_price') }}">
                </div>

                <div class="form-group">
                    <label for="quantity">Кількість</label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 0) }}" min="0">
                </div>

                <div class="form-group">
                    <label for="brand_id">Атрибут</label>
                    <select name="brand_id" class="form-control">
                        <option value="">— не вказано —</option>
                        @foreach($attributes as $attribut)
                            <option value="{{ $attribut->id }}" {{ old('attribute') == $attribut->id ? 'selected' : '' }}>
                                {{ $attribut->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="brand_id">Значення</label>
                    <select name="brand_id" class="form-control">
                        <option value="">— не вказано —</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="category_id">Категорія</label>
                    <select name="category_id" class="form-control">
                        <option value="">— не вказано —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Зберегти</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Скасувати</a>
            </div>
        </form>
    </div>
</div>
@endsection
