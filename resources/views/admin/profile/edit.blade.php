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

    @include('admin.profile.inc.form')
         
    {!! Lte3::formClose() !!}

    
</div>
@endsection