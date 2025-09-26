@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Змінити атрибут: {{ $property->name }}</h2>

    {!! Lte3::formOpen([
        'action' => route('properties.update', $property->id),
        'model' => $property->id,
        'files' => true,
        'method' => 'PUT'
    ]) !!}

    @include('admin.properties.inc.form')


    {!! Lte3::btnSubmit('Зберегти') !!} 
    {!! Lte3::formClose() !!}

</div>
@endsection