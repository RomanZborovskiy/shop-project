@extends('admin.layouts.app')

@section('content')
<section class="content">
        <div class="container-fluid">

    {!! Lte3::formOpen([
        'action' => route('products.store'),
        'model' => null,
        'files' => true,
        'method' => 'POST'
    ]) !!}

         {!! Lte3::select2('brand_id', null, $brands->toArray(), [
            'label' => 'Бренд',
            'placeholder' => 'Оберіть бренд',
        ]) !!}


        {!! Lte3::select2('category_id', null, $categories->toArray(), [
            'label' => 'Категорія',
            'placeholder' => 'Оберіть категорію',
        ]) !!}

        {!! Lte3::text('name', '', [
            'label' => 'Назва продукту',
            'type' => 'text',
        ]) !!}

         {!! Lte3::text('price', '', [
            'label' => 'Ціна',
            'type' => 'number',

        ]) !!}

        {!! Lte3::text('old_price', '', [
            'label' => 'Стара ціна',
            'type' => 'number',
        ]) !!}

        {!! Lte3::text('quantity', '', [
            'label' => 'Кількість',
            'type' => 'number',
        ]) !!}

        {!! Lte3::text('sku', '', [
            'label' => 'артикул',
        ]) !!}

       
        {!! Lte3::select2('status', null, $statuses, [
            'label' => 'Статус',
            'placeholder' => 'Оберіть статус',
        ]) !!}

        {!! Lte3::textarea('description', '', [
            'label' => 'Description',
            'rows' => 3,
        ]) !!}
        
        
          {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}

    </section>
    <!-- /.content -->
@endsection


