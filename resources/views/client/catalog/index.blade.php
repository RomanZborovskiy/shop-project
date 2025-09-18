@extends('client.layouts.app')

@section('title', 'Каталог')

@section('content')
<div class="container">
    <h1>Каталог</h1>

    <ul>
        @foreach($categories as $category)
    <li>
        <a href="{{ route('client.catalog.show', $category) }}">
            {{ $category->name }}
        </a>

        @if($category->children->count())
            <ul>
                @foreach($category->children as $child)
                    <li>
                        <a href="{{ route('client.catalog.show', $child) }}">
                            {{ $child->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach
    </ul>
</div>
@endsection