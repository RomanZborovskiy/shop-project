@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Нова категорія</h2>
    {!! Lte3::formOpen([
        'action' => route('admin.categories.store'),
        'model' => null,
        'files' => true,
        'method' => 'POST'
    ]) !!}

    {!! Lte3::text('name', null, [
        'label' => 'Назва категорії',
        'required' => true
    ]) !!}

    {!! Lte3::select2('parent_id', null, 
        \App\Models\Term::pluck('name', 'id')->toArray(),
        [
            'label' => 'Батьківська категорія',
            'placeholder' => '— Без батьківської —',
        ]
    ) !!}


    {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}

</div>
@endsection



{{-- @extends('admin.layouts.app')

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
        'action' => route('categories.store'),
        'model' => null,
        'files' => true,
        'method' => 'POST'
    ]) !!}

         @include('admin.categories.inc.form')

         {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}

    </section>
    <!-- /.content -->
@endsection --}}


