@extends('client.layouts.app')

@section('title', 'Мої обрані')

@section('content')
<div class="container py-5">
    <h1>Мої обрані товари</h1>
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>
                            <a href="{{ route('client.shop.show', $product) }}">
                                {{ $product->name }}
                            </a>
                        </h5>
                        <p>{{ $product->price }} грн</p>

                        <form method="POST" action="{{ route('client.favorites.product', $product) }}">
                        @csrf
                        <button class="btn btn-sm {{ \App\Facades\Favorite::isFavorite($product) ? 'btn-outline-danger' : 'btn-outline-success' }}" type="submit">
                            {{ \App\Facades\Favorite::isFavorite($product) ? 'Видалити з обраних' : 'Додати в обрані' }}
                        </button>
                    </form>
                    </div>
                </div>
            </div>
        @empty
            <p>Немає обраних товарів</p>
        @endforelse
    </div>

    {{ $products->links() }}
</div>
@endsection
