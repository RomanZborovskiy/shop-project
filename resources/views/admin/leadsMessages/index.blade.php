@extends('admin.layouts.app')

@section('content')
<section class="content">
        <div class="container">
    <h1>Список розсилок</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('mailings.create') }}" class="btn btn-primary mb-3">Створити розсилку</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Тема</th>
                <th>Статус</th>
                <th>Заплановано</th>
                <th>Створено</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
        @forelse($leadMessages as $message)
            <tr>
                <td>{{ $message->id }}</td>
                <td>{{ $message->subject }}</td>
                <td>{{ $message->status }}</td>
                <td>{{ $message->scheduled_at?->format('Y-m-d H:i') ?? 'Одразу' }}</td>
                <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                <td>
                    <a href="{{ route('lead-messages.edit', $message->id) }}" class="btn btn-sm btn-warning">Редагувати</a>
                    <form action="{{ route('lead-messages.destroy', $message->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Ви впевнені?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Видалити</button>
                        
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Поки що немає розсилок</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
       
    </section>

@endsection
