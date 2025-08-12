@extends('admin.layouts.app')

@section('content')
<div class="container">
     <h3>Зміна ролі користувача: {{ $user->name }}</h3>
     @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {!! Lte3::formOpen([
        'action' => route('roles.update', $user),
        'model' => $user,
        'files' => false,
        'method' => 'PATCH'
    ]) !!}


    {!! Lte3::select2('role_id', $user->getRoleNames()->implode(', ') ?? null, $roles->toArray(), [
        'label' => 'Роль',
        'placeholder' => 'Оберіть роль',
    ]) !!}

    {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}
    
</div>
@endsection