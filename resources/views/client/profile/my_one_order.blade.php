@extends('client.layouts.app')

@section('title', 'Замовлення')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Замовлення #{{ $order->id }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
            <p><strong>Сума:</strong> {{ number_format($order->total_price, 2) }} грн</p>
            <p><strong>Статус:</strong>{{$order->status}} </p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Товари у замовленні</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Назва товару</th>
                            <th>Кількість</th>
                            <th>Ціна</th>
                            <th>Сума</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->purchases as $index => $purchase)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $purchase->product?->name ?? '—' }}</td>
                                <td>{{ $purchase->quantity }}</td>
                                <td>{{ number_format($purchase->price, 2) }} грн</td>
                                <td>{{ number_format($purchase->price * $purchase->quantity, 2) }} грн</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('client.profile.orders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Назад до списку
        </a>
    </div>
</div>
@endsection
