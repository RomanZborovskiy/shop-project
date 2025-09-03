@extends('admin.layouts.app')

@section('content')
<h1>Variables</h1>
<a href="{{ route('variables.create') }}" class="btn btn-primary mb-3">Create Variable</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Ключ</th>
            <th>Значення</th>
            <th>Дії</th>
        </tr>
    </thead>
    <tbody>
        @foreach($variables as $var)
        <tr>
            <td>{{ $var->key }}</td>
            <td>{{ $var->value }}</td>
            <td>
                <a href="{{ route('variables.edit', $var) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('variables.destroy', $var) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $variables->links() }}
@endsection
