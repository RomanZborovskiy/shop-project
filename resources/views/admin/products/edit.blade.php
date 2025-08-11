@extends('admin.layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<section class="content">
        <div class="container-fluid">

    {!! Lte3::formOpen([
        'action' => route('products.update', $product),
        'model' => $product,
        'files' => true,
        'method' => 'PATCH'
    ]) !!}

    @include('admin.products.inc.form')


    {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}

    

    

    <form method="GET" action="{{ route('products.edit', $product) }}">
    <select name="attribute_id" onchange="this.form.submit()">
        <option value="">Оберіть атрибут</option>
        @foreach($attributes as $attr)
            <option value="{{ $attr->id }}" {{ request('attribute_id') == $attr->id ? 'selected' : '' }}>
                {{ $attr->name }}
            </option>
        @endforeach
    </select>
</form>

@if($properties->count())
<form method="POST" action="{{ route('products.storeAttribute', $product) }}">
    @csrf
    <select name="property_id">
        @foreach($properties as $prop)
            <option value="{{ $prop->id }}">{{ $prop->value }}</option>
        @endforeach
    </select>
    <button type="submit">Додати</button>
</form>
@endif

    </section>
@endsection