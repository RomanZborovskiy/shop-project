@extends('admin.layouts.app')

@section('content')
<h1>Variable</h1>

    {!! Lte3::formOpen([
        'action' => route('variables.store'),
        'model' => null,
        'files' => true,
        'method' => 'POST'
    ]) !!}

         @include('admin.variables.inc.form')

         {!! Lte3::btnSubmit('Зберегти') !!}
    {!! Lte3::formClose() !!}
@endsection
