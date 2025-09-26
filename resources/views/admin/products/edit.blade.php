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
    
    @include('admin.components.meta', ['model' => $product ?? null])
    <br/>
    <h4>Атрибути</h2>
    @foreach($attributes as $attribute)
    {!! Lte3::select2(
        "attributes[{$attribute->id}]",
        collect($propertyIds)->firstWhere(fn($id) => in_array($id, $attribute->properties->pluck('id')->toArray())),
        $attribute->properties->pluck('value', 'id')->prepend('-- виберіть --', '')->toArray(),
        [
            'label' => $attribute->name,
            'id' => "attribute_{$attribute->id}",
        ]
    ) !!}
    @endforeach
    {!! Lte3::btnSubmit('Зберегти') !!}   
    {!! Lte3::formClose() !!}

    </section>
@endsection