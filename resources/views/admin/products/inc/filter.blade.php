<button class="btn btn-primary mb-3" type="button" data-toggle="collapse" data-target="#filters">
    Використати фільтр
</button>
<div class="collapse" id="filters">
{!! Lte3::formOpen([
    'action' => route('products.index'),
    'model' => null,
    'files' => true,
    'method' => 'GET'
]) !!}

    {!! Lte3::text('name', request('name') ?? null, [
            'label' => 'Назва продукту',
    ]) !!}

    {!! Lte3::number('price_from', request('price_from') ?? null, [
            'label' => 'Ціна від',
    ]) !!}

    {!! Lte3::number('price_to', request('price_to') ?? null, [
            'label' => 'Ціна до',
    ]) !!}

    {!! Lte3::select2('category_id', request('category_id'), $categories->toArray(), [
        'label' => 'Категорія',
        'placeholder' => 'Оберіть категорію',
    ]) !!}

    {!! Lte3::select2('has_images', request('has_images'), [
        ''  => 'Всі',
        '1' => 'З фото',
        '0' => 'Без фото',
    ], [
        'label' => 'Наявність фото',
        'placeholder' => 'Оберіть варіант',
    ]) !!}

    {!! Lte3::select2('sort_by', request('sort_by'), [
        ''      => 'Сортувати...',
        'name'  => 'Назва',
        'price' => 'Ціна',
        'sku'   => 'Артикул',
    ], [
        'label' => 'Сортування',
        'placeholder' => 'Оберіть поле',
    ]) !!}

    {!! Lte3::select2('direction', request('direction'), [
        'asc'  => 'За зростанням',
        'desc' => 'За спаданням',
    ], [
        'label' => 'Напрямок',
        'placeholder' => 'Оберіть напрямок',
    ]) !!}

    {!! Lte3::btnSubmit('Фільтрувати') !!}
{!! Lte3::formClose() !!}
</div>
