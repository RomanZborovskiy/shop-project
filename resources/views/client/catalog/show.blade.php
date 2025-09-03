@extends('client.layouts.app')

@section('title', 'Магазин')

@section('content')
<div class="container-fluid shop py-5">  
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-3">
                <form method="GET" action="{{ route('client.catalog.show', $category->slug) }}">

                    <div class="mb-4">
                        <h4 class="mb-2">Ціна</h4>
                        <div class="d-flex align-items-center">
                            <input type="number" name="price_from" class="form-control me-2" placeholder="Від"
                                   value="{{ request('price_from') }}">
                            <input type="number" name="price_to" class="form-control" placeholder="До"
                                   value="{{ request('price_to') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="mb-2">Бренд</h4>
                        <select name="brand_id" class="form-select">
                            <option value="">Всі</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <h4 class="mb-2">Сортувати</h4>
                        <select name="sort_by" class="form-select mb-2">
                            <option value="">За замовчуванням</option>
                            <option value="name" {{ request('sort_by')=='name' ? 'selected' : '' }}>Алфавіт</option>
                            <option value="price" {{ request('sort_by')=='price' ? 'selected' : '' }}>Ціна</option>
                        </select>
                        <select name="direction" class="form-select">
                            <option value="asc" {{ request('direction')=='asc' ? 'selected' : '' }}>Зростання</option>
                            <option value="desc" {{ request('direction')=='desc' ? 'selected' : '' }}>Спадання</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Фільтрувати</button>
                </form>
            </div>


            <div class="col-lg-9">
                <div class="row g-4 product">
                    @forelse($products as $product)
                        <div class="col-lg-4">
                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">
                                <div class="product-item-inner border rounded">
                                    <div class="product-item-inner-item">
                                        <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" 
                                             class="img-fluid w-100 rounded-top" alt="">
                                        <div class="product-details">
                                            <a href="{{ route('client.shop.show', $product) }}"><i class="fa fa-eye fa-1x"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center rounded-bottom p-4">
                                        <a href="#" class="d-block mb-2">{{ $product->brand->name ?? '' }}</a>
                                        <a href="#" class="d-block h4">{{ $product->name }}</a>
                                        <span class="text-primary fs-5">
                                            {{ currency_convert($product->price, currency_active()) }} {{ currency_name() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Немає товарів за даним запитом.</p>
                    @endforelse
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
