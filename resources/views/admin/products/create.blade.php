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
        'action' => route('products.store'),
        'model' => null,
        'files' => true,
        'method' => 'POST'
    ]) !!}

         @include('admin.products.inc.form')

         @include('admin.components.meta', ['model' => $product ?? null])

         {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}

    </section>
@endsection



