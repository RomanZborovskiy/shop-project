@extends('client.layouts.app')

@section('title', 'Корзина')

@section('content')

<div class="container-fluid py-5">
    <div class="container py-5">
        @if($cart->purchases->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->purchases as $purchase)
                            <tr>
                                <th scope="row">
                                    <p class="mb-0 py-4">{{ $purchase->product->name }}</p>
                                </th>
                                <td>
                                    <p class="mb-0 py-4">{{ $purchase->product->brand->name ?? '—' }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 py-4">{{currency_convert($purchase->price, currency_active())}} {{ currency_name() }}</p>
                                </td>
                                <td>
                                    <form action="{{ route('cart.update', $purchase) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group quantity py-4" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button type="submit" name="quantity" value="{{ $purchase->quantity - 1 }}"
                                                    class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" name="quantity"
                                                class="form-control form-control-sm text-center border-0"
                                                value="{{ $purchase->quantity }}">
                                            <div class="input-group-btn">
                                                <button type="submit" name="quantity" value="{{ $purchase->quantity + 1 }}"
                                                    class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <p class="mb-0 py-4">
                                        {{ number_format(currency_convert($purchase->price, currency_active()) * $purchase->quantity, 2) }} 
                                        {{ currency_name() }}
                                    </p>
                                </td>
                                <td class="py-4">
                                    <form action="{{ route('cart.remove', $purchase) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-md rounded-circle bg-light border">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code">
                <button class="btn btn-primary rounded-pill px-4 py-3" type="button">Apply Coupon</button>
            </div>

            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <p class="mb-0">{{currency_convert($cart->total_price, currency_active())}} {{ currency_name() }}</p>
                            </div>
                        </div>
                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Total</h5>
                            <p class="mb-0 pe-4">{{currency_convert($cart->total_price, currency_active())}} {{ currency_name() }}</p>
                        </div>
                        <<a href="{{ route('checkout.index') }}" 
                            class="btn btn-primary rounded-pill px-4 py-3 text-uppercase mb-4 ms-4">
                            Proceed Checkout
                        </a>
                    </div>
                </div>
            </div>
        @else
            <h3 class="text-center">Ваш кошик порожній 🛒</h3>
        @endif
    </div>
</div>
@endsection
