@extends('admin.layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<section class="content">
        <div class="container-fluid">

    {!! Lte3::formOpen([
        'action' => route('users.update', $user),
        'model' => $user,
        'files' => true,
        'method' => 'PATCH'
    ]) !!}

    @include('admin.users.inc.form')


    {!! Lte3::formClose() !!}

    </section>
@endsection