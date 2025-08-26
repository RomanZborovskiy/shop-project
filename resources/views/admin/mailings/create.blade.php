@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Нова розсилка</h1>

    {!! Lte3::formOpen([
        'action' => route('mailings.store'),
        'model' => null,
        'files' => true,
        'method' => 'POST'
    ]) !!}

    @include('admin.mailings.inc.form')

    {!! Lte3::formClose() !!}
</div>
</div>
@endsection

