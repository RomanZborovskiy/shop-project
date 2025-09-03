@extends('client.layouts.app')

@section('title', 'Магазин')
@section('content')

<div class="container-fluid shop py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-5 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="product-categories mb-4">

                    </div>
                </div>
                <div class="col-lg-7 col-xl-9 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row g-4 single-product">
                        <div class="col-xl-6">
                            <div class="single-carousel owl-carousel">
                                @foreach($product->getMedia('images') as $media)
                                    <div class="single-item"
                                        data-dot="<img class='img-fluid' src='{{ $media->getUrl('thumb') }}' alt=''>">
                                        <div class="single-inner bg-light rounded">
                                            <img src="{{ $media->getUrl() }}" class="img-fluid rounded" alt="{{ $product->name }}">
                                        </div>
                                    </div>
                                @endforeach
                                                    
                            </div>
                        </div>
                        {{--  --}}
                        <div class="col-xl-6">
                            <h4 class="fw-bold mb-3">{{$product->name}}</h4>
                            <p class="mb-3">Category: {{$product->category->name}}</p>
                            <h5 class="fw-bold mb-3">{{currency_convert($product->price, currency_active())}} {{ currency_name() }}</h5>
                            <div class="d-flex mb-4">
                                <i class="fa fa-star text-secondary"></i>
                                <i class="fa fa-star text-secondary"></i>
                                <i class="fa fa-star text-secondary"></i>
                                <i class="fa fa-star text-secondary"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="d-flex flex-column mb-3">
                                <small>Product SKU: {{$product->sku}}</small>
                                <small>Available: <strong class="text-primary">{{$product->quantity}} items in stock</strong></small>
                            </div>
                            <p class="mb-4">The generated Lorem Ipsum is therefore always free from repetition injected
                                humour, or non-characteristic words etc.</p>
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" class="form-control w-25 d-inline">
                                <button type="submit" class="btn btn-primary">Додати в кошик</button>
                            </form>
                            <br/>
                                    @auth
                                        @if(auth()->user()->favoriteProducts->contains($product->id))
                                            <form action="{{ route('client.favorites.destroy', $product) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-heart-fill"></i> В обраних
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('client.favorites.store', $product) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="bi bi-heart"></i> Додати в обрані
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                        </div>
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button"
                                        role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                        aria-controls="nav-about" aria-selected="true">Description</button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel"
                                    aria-labelledby="nav-about-tab">
                                    <p>{!!$product->description!!}</p>
                                </div>
                                <div class="container">

                                <h4 class="mt-5">Відгуки</h4>

                                @auth
                                    <form action="{{ route('client.reviews.store', $product) }}" method="POST" class="mb-5">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="rating" class="form-label">Оцінка:</label>
                                            <select name="rating" required class="form-control">
                                                <option value="5">⭐⭐⭐⭐⭐</option>
                                                <option value="4">⭐⭐⭐⭐</option>
                                                <option value="3">⭐⭐⭐</option>
                                                <option value="2">⭐⭐</option>
                                                <option value="1">⭐</option>
                                            </select>
                                            @error('rating') <div class="text-danger small">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="comment" class="form-label">Ваш відгук:</label>
                                            <textarea name="comment" id="comment" rows="3" class="form-control">{{ old('comment') }}</textarea>
                                            @error('comment') <div class="text-danger small">{{ $message }}</div> @enderror
                                        </div>

                                        <button type="submit" class="btn btn-sm btn-primary">Надіслати</button>
                                    </form>
                                @else
                                    <p><a href="{{ route('login') }}">Увійдіть</a>, щоб залишити відгук</p>
                                @endauth

                                @foreach($product->reviews as $review)
                                    @include('client.catalog.inc.review', ['review' => $review])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection