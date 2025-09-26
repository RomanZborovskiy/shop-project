@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Змінити атрибут: {{ $attribute->name }}</h2>

    {!! Lte3::formOpen([
        'action' => route('attributes.update', $attribute->id),
        'model' => $attribute->id,
        'files' => true,
        'method' => 'PUT'
    ]) !!}

    {!! Lte3::text('name', $attribute->name ?? null, [
        'label' => 'Назва атрибута',
        'type' => 'text',
    ]) !!}


    {!! Lte3::btnSubmit('Зберегти') !!} 
    {!! Lte3::formClose() !!}

</div>
@endsection