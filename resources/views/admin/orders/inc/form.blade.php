{!! Lte3::select2('status', $order->status ?? null, App\Models\Order::statusesList(), [
            'label' => 'Статус',
            'placeholder' => 'Оберіть статус',
        ]) !!}

        {!! Lte3::select2('type', $order->type ?? null, App\Models\Order::typeList(), [
            'label' => 'Вид оплати',
            'placeholder' => 'Оберіть вид оплати',
        ]) !!}

        @php
            $info = $order->user_info ?? [];
        @endphp

        {!! Lte3::text('user_info[name]', $info['name'] ?? null, [
            'label' => 'Ім`я',
        ]) !!}

        {!! Lte3::text('user_info[phone]', $info['phone'] ?? null, [
            'label' => 'Телефон',
        ]) !!}

        {!! Lte3::text('user_info[email]', $info['email'] ?? null, [
            'label' => 'email',
        ]) !!}

        {!! Lte3::text('user_info[address]', $info['address'] ?? null, [
            'label' => 'Адреса',
        ]) !!}

        <hr>
        <h4>Покупки</h4>
        <table class="table" id="purchasesTable">
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Кількість</th>
                    <th>Ціна</th>
                    <th>Сума</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->purchases as $index => $purchase)
                <tr>
                    <td>
                        {{ $purchase->product->name }}
                        {!! Lte3::hidden("purchases[$index][product_id]", $purchase->product_id  ?? null, []) !!}
                    </td>
                    <td>
                        {!! Lte3::number("purchases[$index][quantity]", $purchase->quantity ?? null, [
                            'class' => 'form-control quantity',
                            'label' => null,
                            'min' => '1',
                            'step' => '1'
                        ]) !!}
                    </td>
                    <td>
                        {{ $purchase->price }}
                        {!! Lte3::hidden("purchases[$index][price]", $purchase->price ?? null, [
                            'class' => 'price'
                        ]) !!}
                    </td>
                    <td class="line-total">{{ number_format($purchase->price * $purchase->quantity, 2) }}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">✖</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <h4>Загальна сума: <span id="totalPrice">{{ number_format($order->total_price, 2) }}</span> грн</h4>

        {!! Lte3::btnSubmit('Зберегти') !!}