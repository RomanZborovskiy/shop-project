@extends('client.layouts.app')

@section('title', $page->name)

@section('content')
<div class="container py-5">
    <h1 class="h3">{{ $page->name }}</h1>
    <div class="card p-4 mt-3">
        {!! $page->description !!}
    </div>
</div>
@endsection