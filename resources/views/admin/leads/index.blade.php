@extends('admin.layouts.app')

@section('content')
<section class="content">
        <div class="container mt-4">
    <div class="card">
        <h1>Ліди</h1>
        <div class="card-tools">
            <a href="{{ route('lead-messages.index') }}" class="btn btn-primary btn-sm">Додати розсилку</a>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Тип</th>
            <th>Дані</th>
            <th>Дата</th>
        </tr>
    </thead>
    <tbody>
        @foreach($leads as $lead)
        <tr>
            <td>{{ $lead->id }}</td>
            <td>{{ $lead->type }}</td>
            <td>
                @foreach($lead->fields as $key => $value)
                    <strong>{{ $key }}:</strong> {{ $value }}<br>
                @endforeach
            </td>
            <td>{{ $lead->created_at->format('d.m.Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
        </div>
        

        <div class="card-footer">
            {{ $leads->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
       
    </section>

@endsection
