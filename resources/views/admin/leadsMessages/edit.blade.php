@extends('admin.layouts.app')

@section('content')
<div class="container">
     <h3>Зміна розсилки: {{ $leadMessage->subject }}</h3>
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
        'action' => route('lead-messages.store'),
        'model' => null,
        'files' => true,
        'method' => 'POST'
    ]) !!}

    @include('admin.leadsMessages.inc.form')

    {!! Lte3::formClose() !!}
    
</div>
@endsection