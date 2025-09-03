@extends('client.layouts.app')

@section('title', 'Оформлення замовлення')

@section('content')

<div class="container-fluid bg-light overflow-hidden py-5">
    <div class="container py-5">
        <h1 class="mb-4 wow fadeInUp" data-wow-delay="0.1s">Оформлення замовлення</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <div class="row g-5">
                <div class="col-md-12 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                    
                    @if ($errors->any())
                        <div class="bg-danger text-white p-3 rounded mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h4 class="mb-3">1. Контактні дані</h4>
                    @guest
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-item w-100">
                                    <label class="form-label my-2">Ім'я*</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-item w-100">
                                    <label class="form-label my-2">Телефон*</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-2">Email*</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    @else
                        <div class="bg-primary bg-opacity-10 p-3 rounded mb-3">
                            <p>Ви оформлюєте замовлення як <strong>{{ auth()->user()->name }}</strong>.</p>
                            <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                            <input type="hidden" name="phone" value="{{ auth()->user()->phone ?? '' }}">
                        </div>
                    @endguest

                    <h4 class="mt-4 mb-3">2. Доставка</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-item">
                                <label class="form-label my-2">Місто*</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-item">
                                <label class="form-label my-2">Відділення/Поштомат*</label>
                                <input type="text" name="delivery" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-4 mb-3">3. Примітки</h4>
                    <div class="form-item">
                        <textarea name="notes" class="form-control" rows="5" placeholder="Коментар до замовлення (необов'язково)"></textarea>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-start">Назва</th>
                                    <th>Ціна</th>
                                    <th>К-сть</th>
                                    <th>Разом</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->purchases as $purchase)
                                    <tr class="text-center">
                                        <th class="text-start py-3">{{ $purchase->product->name }}</th>
                                        <td class="py-3">{{currency_convert($purchase->price, currency_active())}} {{ currency_name() }}</td>
                                        <td class="py-3">{{ $purchase->quantity }}</td>
                                        <td class="py-3">
                                            {{ number_format(currency_convert($purchase->price, currency_active()) * $purchase->quantity, 2) }} 
                                            {{ currency_name() }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-end fw-bold py-3">Всього</td>
                                    <td class="py-3 fw-bold">
                                        {{ number_format(currency_convert($cart->total_price, currency_active()), 2) }} 
                                        {{ currency_name() }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h4 class="mt-4 mb-3">4. Оплата</h4>
                    <div class="form-check mb-2">
                        <input type="radio" class="form-check-input" name="payment_method" value="cash_on_delivery" checked>
                        <label class="form-check-label">Оплата при отриманні</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="radio" class="form-check-input" name="payment_method" value="online">
                        <label class="form-check-label">Онлайн-оплата (Fondy)</label>
                    </div>

                    <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary py-3 px-4 text-uppercase w-100">
                                Підтвердити замовлення
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
