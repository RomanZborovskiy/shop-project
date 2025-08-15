@extends('admin.layouts.app')

@section('content')
<section class="content">
        <div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Замовлення</h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ім'я замовиника</th>
                        <th>Ціна</th>
                        <th>Статус</th>
                        <th>Вид</th>
                        <th>Створено</th>
                        <th>Оновлено</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? '—'}}</td>
                            <td>{{ $order->total_price }} грн</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->type }}</td>                    
                            <td>{{ $order->created_at}}</td>
                            <td>{{ $order->updated_at }}</td>
                            <td>
                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Редагувати</a>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Ви впевнені?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Видалити</button>
                                    
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Замовлень не знайдено.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        

        <div class="card-footer">
            {{ $orders->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
    </section>

@endsection
