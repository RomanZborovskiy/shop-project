@extends('client.layouts.app')

@section('title', 'Мої обрані')

@section('content')
<div class="container py-5">
    <h1>Мої обрані товари</h1>
    <div class="row">
        @foreach($products as $product)
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
                            <button class="btn btn-sm btn-outline-danger" type="submit">
                                Видалити з обраних
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $products->links() }}
</div>
@endsection
