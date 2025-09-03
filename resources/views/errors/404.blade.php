@extends('client.layouts.app')

@section('title', 'Сторінку не знайдено')
 
@section('content')
 <div class="container-fluid py-5">
        <div class="container py-5 text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <i class="bi bi-exclamation-triangle display-1 text-secondary"></i>
                    <h1 class="display-1">404</h1>
                    <h1 class="mb-4">Сторінку не знайдено</h1>
                    <p class="mb-4">Вибачте, сторінки, яку ви шукали, немає на нашому вебсайті! Можливо, варто перейти на нашу головну сторінку або спробувати скористатися пошуком?</p>
                    <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('client.dashboard') }}">Перейти на головну</a>
                </div>
            </div>
        </div>
    </div>
    @endsection