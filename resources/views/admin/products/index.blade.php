@extends('admin.layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid mt-4"> 
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Продукти</h3>
                <div class="card-tools">                 
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">+ Додати</a>
                </div>
            </div>

            @include('admin.products.inc.filter')

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Фото</th>
                            <th>Назва</th>
                            <th>Ціна</th>
                            <th>Категорія</th>
                            <th>Бренд</th>
                            <th>Кількість</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if($product->hasMedia('images'))
                                        <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}"  
                                            width="50" height="50">
                                    @else
                                        <span>—</span>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    @foreach(config('currency.available') as $currency)
                                        {{ $currency }}: {{ currency_convert($product->price, $currency) }}
                                        <br/>
                                    @endforeach
                                </td>
                                <td>{{ $product->category->name ?? '—' }}</td>
                                <td>{{ $product->brand->name ?? '—' }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Редагувати</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Ви впевнені?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Видалити</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Продуктів не знайдено.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3 d-flex gap-2">
                <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="file">Оберіть Excel файл:</label>
                    <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" required>
                    <button type="submit" class="btn btn-info btn-sm">Імпортувати</button>
                </form>

                <form action="{{ route('products.export') }}" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">
                        Експортувати продукти
                    </button>
                </form>
            </div>

            <div class="card-footer">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</section>
@endsection

<script>
document.getElementById('attributeSelect').addEventListener('change', function () {
  let attributeId = this.value;
  let valueSelect = document.getElementById('valueSelect');

  fetch(`/admin/attributes/${attributeId}/values`)
    .then(res => res.json())
    .then(data => {
      valueSelect.innerHTML = ''; 
      data.forEach(function (item) {
        let option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.value;
        valueSelect.appendChild(option);
      });
      valueSelect.disabled = false;
    });
});
</script>
