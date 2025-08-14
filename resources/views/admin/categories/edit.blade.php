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
        'action' => route('categories.update', $category),
        'model' => $category,
        'files' => true,
        'method' => 'PUT'
    ]) !!}

        {!! Lte3::text('name', $category->name ?? null, [
            'label' => 'Назва категорії',
            'type' => 'text',
        ]) !!}

        {!! Lte3::select2('parent_id', $product->parent_id ?? null, $categories->toArray(), [
            'label' => 'Батьківська категорія',
            'placeholder' => 'Оберіть батьківську категорію',
        ]) !!}


    {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}


    </section>
@endsection