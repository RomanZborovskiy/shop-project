@extends('admin.layouts.app')

@section('content')
<section class="content">
        <div class="container mt-4">
    <div class="card">
        <div class="card-header">
             <div class="container">
                <h2>Особистий кабінет</h2>
                <p><strong>Ім'я:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>

                <a href="{{ route('profile.confirm.password.form') }}" class="btn btn-primary">Змінити дані</a>
            </div>
        </div>

       
    </section>

@endsection
