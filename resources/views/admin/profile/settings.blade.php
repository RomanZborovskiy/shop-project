@extends('admin.layouts.app')

@section('content')
<form action="{{ route('admin.settings.generateSitemap') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">
        Згенерувати карту сайту
    </button>
</form>
@endsection