@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Редагування профілю</h3>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

     {!! Lte3::formOpen([
        'action' => route('profile.update'),
        'model' => null,
        'files' => true,
        'method' => 'PATCH'
    ]) !!}

         {!! Lte3::text('name', Auth::user()->name ?? null, [
            'label' => 'Ім’я',
            'type' => 'text',
        ]) !!}

        {!! Lte3::text('email', Auth::user()->email ?? null, [
            'label' => 'email',
            'type' => 'email',
        ]) !!}

        {!! Lte3::file('avatar', Auth::user()->avatar_url ?? null, [
            'label' => 'Аватарка',
            'help' => 'Оберіть файл зображення',
        ]) !!}

        {!! Lte3::text('password',  null, [
            'label' => 'Новий пароль',
            'type' => 'password',
        ]) !!}

        {!! Lte3::text('password_confirmation',  null, [
            'label' => 'Підтвердження пароля',
            'type' => 'password',
        ]) !!}

         {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}

    
</div>
@endsection