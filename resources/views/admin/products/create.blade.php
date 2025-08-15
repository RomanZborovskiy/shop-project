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

         {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}

    </section>
@endsection

@section('scripts')
    <script>
       $('[name="subcategory_id"]').select2({
    placeholder: 'Оберіть підкатегорію',
    allowClear: true,
    ajax: {
        url: function () {
            let parentId = $('[name="category_id"]').val();
            console.log('🔹 AJAX URL:', '{{ route('lte3.categories.suggest') }}?parent_id=' + parentId);
            return '{{ route('lte3.categories.suggest') }}?parent_id=' + parentId;
        },
        dataType: 'json',
        delay: 250,
        data: function (params) {
            console.log('🔹 Запитуємо з терміном:', params.term);
            return { term: params.term };
        },
        processResults: function (data) {
            console.log('🔹 Отримано дані:', data);
            return { results: data.results };
        }
    }
});

$('[name="category_id"]').on('change', function () {
    console.log('🔹 Зміна категорії:', $(this).val());
});
    </script>
@endsection


