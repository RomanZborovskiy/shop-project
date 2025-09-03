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
                            <a href="{{ route('client.catalog.show', $product) }}">
                                {{ $product->name }}
                            </a>
                        </h5>
                        <p>{{ $product->price }} грн</p>

                        <form action="{{ route('client.favorites.destroy', $product) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Видалити</button>
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
