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
        'action' => route('admin.categories.update', $term),
        'model' => $term,
        'files' => true,
        'method' => 'PUT'
    ]) !!}

    {!! Lte3::text('name', $term->name, [
        'label' => 'Назва категорії',
        'required' => true
    ]) !!}

    {!! Lte3::select2('parent_id', $term->parent_id, 
        \App\Models\Term::pluck('name', 'id')->toArray(),
        [
            'label' => 'Батьківська категорія',
            'placeholder' => '— Без батьківської —',
        ]
    ) !!}

        @include('admin.components.meta', ['model' => $category ?? null])
        
    {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}


    </section>
@endsection