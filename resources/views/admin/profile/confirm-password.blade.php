@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Підтвердження пароля</h3>
    {!! Lte3::formOpen([
        'action' => route('profile.confirm.password'),
        'model' => null,
        'files' => true,
        'method' => 'POST'
    ]) !!}

        {!! Lte3::text('password',  null, [
            'label' => 'Введфть пароль',
            'type' => 'password',
        ]) !!}

    {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}
    
</div>
@endsection