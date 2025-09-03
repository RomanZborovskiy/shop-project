@extends('client.layouts.app')

@section('title', 'Магазин')

@section('content')
    <div class="container-fluid shop py-5">
        <div class="container py-5">
            <div class="row g-4">
                
                <div class="col-lg-9 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="tab-content">
                        <div id="tab-5" class="tab-pane fade show p-0 active">
                            <div class="row g-4 product">
                                @foreach($products as $product)
                                <div class="col-lg-4">
                                    <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">
                                        <div class="product-item-inner border rounded">
                                            <div class="product-item-inner-item">
                                                <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" class="img-fluid w-100 rounded-top" alt="">
                                                {{-- <div class="product-new">New</div> --}}
                                                <div class="product-details">
                                                    <a href="#"><i class="fa fa-eye fa-1x"></i></a>
                                                </div>
                                            </div>
                                            <div class="text-center rounded-bottom p-4">
                                                <a href="#" class="d-block mb-2">{{$product->category->name}}</a>
                                                <a href="#" class="d-block h4">{{$product->name}} </a>
                                                <del class="me-2 fs-5">
                                                @if($product->old_price)
                                                    {{ currency_convert($product->old_price, currency_active()) }} {{ currency_name() }}
                                                @endif
                                                </del>
                                                <span class="text-primary fs-5">{{currency_convert($product->price, currency_active())}} {{ currency_name() }}</span>
                                            </div>
                                        </div>
                                        <div
                                            class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">
                                            <a href="#"
                                                class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i
                                                    class="fas fa-shopping-cart me-2"></i> Добавити до замовлення</a>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex">
                                                    <i class="fas fa-star text-primary"></i>
                                                    <i class="fas fa-star text-primary"></i>
                                                    <i class="fas fa-star text-primary"></i>
                                                    <i class="fas fa-star text-primary"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <div class="d-flex">
                                                    <a href="#"
                                                        class="text-primary d-flex align-items-center justify-content-center me-3"><span
                                                            class="rounded-circle btn-sm-square border"><i
                                                                class="fas fa-random"></i></i></a>
                                                    <a href="#"
                                                        class="text-primary d-flex align-items-center justify-content-center me-0"><span
                                                            class="rounded-circle btn-sm-square border"><i
                                                                class="fas fa-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $products->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Page End -->
@endsection