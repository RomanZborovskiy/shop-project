@extends('client.layouts.app')

@section('title', 'Мій профіль')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Мій профіль</h5>
        </div>
        <div class="card-body">
            <p><strong>Ім’я:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>

            <a href="{{ route('client.profile.edit') }}" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i> Редагувати профіль
            </a>
        </div>
    </div>
</div>
@endsection
