@component('mail::message')
# Новий користувач у системі

Ім’я: {{ $newUser->name }}  
Email: {{ $newUser->email }}

Дякуємо!  
@endcomponent