@extends('client.layouts.app')

@section('title', 'Сайт недоступний')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5 text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <i class="bi bi-gear-wide-connected display-1 text-warning"></i>
                <h1 class="display-1">503</h1>
                <h1 class="mb-4">Послуга недоступна</h1>
                <p class="mb-4">
                    Наш сайт тимчасово недоступний через технічні роботи.  
                    Будь ласка, спробуйте пізніше.
                </p>
                <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('client.dashboard') }}">
                    Спробувати знову
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
