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
    {!! Lte3::btnSubmit('Зберегти') !!}   
    {!! Lte3::formClose() !!}

    {{-- <div class="card card-primary">
    <div class="card-body">
        <form method="GET" action="{{ route('products.edit', $product) }}">
            <div class="form-group">
                <label for="attribute_id">Оберіть атрибут</label>
                <select name="attribute_id" id="attribute_id" class="form-control select2" onchange="this.form.submit()">
                    <option value="">Оберіть атрибут</option>
                    @foreach($attributes as $attr)
                        <option value="{{ $attr->id }}" {{ request('attribute_id') == $attr->id ? 'selected' : '' }}>
                            {{ $attr->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        @if($properties->count())
            <form method="POST" action="{{ route('products.storeAttribute', $product) }}">
                @csrf
                <div class="form-group mt-3">
                    <label for="property_id">Оберіть значення</label>
                    <select name="property_id" id="property_id" class="form-control select2">
                        @foreach($properties as $prop)
                            <option value="{{ $prop->id }}">{{ $prop->value }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus"></i> Додати
                </button>
            </form>
        @endif
    </div>
</div> --}}
    </section>
@endsection