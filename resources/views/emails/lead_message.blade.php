@component('mail::message')
# {{ $subjectText }}

{!! nl2br(e($bodyText)) !!}

@slot('subcopy')
@if(config('app.name'))
{{ config('app.name') }}
@endif
@endslot
@endcomponent
