@extends('client.layouts.app')

@section('title', 'Доступ заборонено')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5 text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <i class="bi bi-shield-lock display-1 text-danger"></i>
                <h1 class="display-1">403</h1>
                <h1 class="mb-4">Access Forbidden</h1>
                <p class="mb-4">
                    У вас немає прав для доступу до цієї сторінки.  
                    Якщо ви вважаєте, що це помилка — зверніться до адміністратора.
                </p>
                <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('client.dashboard') }}">
                    Перейти на головну
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
