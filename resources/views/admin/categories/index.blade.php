@extends('admin.layouts.app')

@section('content')
    <h1>Категорії</h1>

    {!! Lte3::nestedset($terms, [
        'label' => 'Categories',
        'has_nested' => true,
        'routes' => [
            'edit' => 'admin.categories.edit',
            'create' => 'admin.categories.create',
            'delete' => 'admin.categories.destroy',
            'order' => 'admin.categories.order',
            'params' => [],
        ],
    ]) !!}
@endsection

@push('scripts')
<script>
    $(document).on('nestedset:reorder', function (e, data) {
        $.post("{{ route('admin.categories.order') }}", {
            _token: '{{ csrf_token() }}',
            order: data
        }).done(function () {
            console.log('Order updated');
        });
    });
</script>
@endpush





