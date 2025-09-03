@extends('client.layouts.app')

@section('title', 'Мої замовлення')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Мої замовлення</h5>
        </div>
        <div class="card-body">
            @if($orders->isEmpty())
                <p class="text-muted">У вас ще немає замовлень.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Дата</th>
                                <th>Сума</th>
                                <th>Статус</th>
                                <th>Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ number_format($order->total_price, 2) }} грн</td>
                                    <td>
                                        <span class="badge 
                                            @if($order->status == 'pending') bg-warning 
                                            @elseif($order->status == 'completed') bg-success 
                                            @elseif($order->status == 'canceled') bg-danger 
                                            @else bg-secondary @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('client.profile.orders.show', $order->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                           <i class="bi bi-eye"></i> Переглянути
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection