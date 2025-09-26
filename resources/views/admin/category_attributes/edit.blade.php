@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Атрибути для категорії: {{ $category->name }}</h2>

    {!! Lte3::formOpen([
        'action' => route('categories.attributes.update', $category->id),
        'model' => $category->id,
        'files' => true,
        'method' => 'PATCH'
    ]) !!}

    {!! Lte3::select2('attributes[]', $selected, $attributes->toArray(), [
        'label' => 'Атрибути',
        'placeholder' => 'Оберіть атрибути',
        'multiple' => true
    ]) !!}


    {!! Lte3::btnSubmit('Зберегти') !!} 
    {!! Lte3::formClose() !!}

</div>
@endsection