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

         @include('admin.products.inc.form')

        {!! Lte3::select2('attribute', null, $attributes->toArray(), [
            'label' => 'Атрибут',
            'placeholder' => 'Оберіть категорію',
        ]) !!}

         {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}

    </section>
@endsection