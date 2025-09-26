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
            'action' => route('admin.categories.update', $category),
            'model' => $category,
            'files' => true,
            'method' => 'PUT'
        ]) !!}

        {!! Lte3::text('name', $category->name ?? null, [
            'label' => 'Назва категорії',
            'required' => true
        ]) !!}

        {!! Lte3::select2('parent_id', $category->parent_id, 
            \Fomvasss\SimpleTaxonomy\Models\Term::pluck('name', 'id')->toArray(),
            [
                'label' => 'Батьківська категорія',
                'placeholder' => '— Без батьківської —',
            ]
        ) !!}

        @include('admin.components.meta', ['model' => $category])
        
        {!! Lte3::btnSubmit('Зберегти') !!}
        {!! Lte3::formClose() !!}

    </div>
</section>
@endsection
