@component('mail::message')
# {{ $subjectText }}



@slot('subcopy')
@if(config('app.name'))
{{ config('app.name') }}
@endif
@endslot
@endcomponent
