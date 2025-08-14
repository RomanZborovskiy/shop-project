@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Редагувати замовлення #{{ $order->id }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        {!! Lte3::formOpen([
        'action' => route('orders.update', $order->id),
        'model' => $order,
        'files' => true,
        'method' => 'PATCH'
    ]) !!}

       @include('admin.orders.inc.form')
       
        {!! Lte3::formClose() !!}
</div>
<script>
function updateTotal() {
    let total = 0;

    document.querySelectorAll('#purchasesTable tbody tr').forEach(row => {
        let qty = parseFloat(row.querySelector('.quantity').value) || 0;
        let price = parseFloat(row.querySelector('.price').value) || 0;

        let sum = qty * price;
        row.querySelector('.line-total').textContent = sum.toFixed(2);

        total += sum;
    });

    document.getElementById('totalPrice').textContent = total.toFixed(2);
}

document.addEventListener('input', function (e) {
    if (e.target.classList.contains('quantity')) {
        updateTotal();
    }
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-row')) {
        e.target.closest('tr').remove();
        updateTotal();
    }
});
updateTotal();
</script>
@endsection