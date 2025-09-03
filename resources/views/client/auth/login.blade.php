@extends('client.layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Welcome Back</h3>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember">
                                <label class="form-check-label">Remember me</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-muted small">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Sign In</button>
                    </form>

                    <div class="text-center mt-3">
                        <small class="text-muted">Don't have an account?</small>
                        <a href="{{ route('register') }}">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
