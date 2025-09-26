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
@section('content')
<div class="container">
    <h2>Створити властивість</h2>

    {!! Lte3::formOpen([
        'action' => route('properties.store'),
        'model' => null,
        'files' => true,
        'method' => 'POST'
    ]) !!}

    @include('admin.properties.inc.form')


    {!! Lte3::btnSubmit('Зберегти') !!} 
    {!! Lte3::formClose() !!}

</div>
@endsection


