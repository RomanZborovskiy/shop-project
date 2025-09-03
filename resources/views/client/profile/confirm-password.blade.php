@extends('client.layouts.app')

@section('title', 'Мій профіль')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Підтвердження пароля</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('client.profile.confirm.password') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="password" class="form-label">Введіть пароль</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-shield-lock"></i> Підтвердити
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection