@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Нова розсилка</h1>

    {!! Lte3::formOpen([
        'action' => route('lead-messages.store'),
        'model' => null,
        'files' => true,
        'method' => 'POST'
    ]) !!}

    @include('admin.leadsMessages.inc.form')

    {!! Lte3::formClose() !!}
</div>
</div>
@endsection

