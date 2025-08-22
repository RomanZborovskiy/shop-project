@extends('admin.layouts.app')

@section('content')
<section class="content">
        <div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ролі користувачів</h3>
        </div>
        @include('admin.roles.inc.filter')

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ім'я</th>
                        <th>email</th>
                        <th>Дата реєстрації</th>
                        <th>Роль</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->getRoleNames()->implode(', ') ?: '—' }}</td>
                            <td>
                                <a href="{{ route('roles.edit', $user->id) }}" class="btn btn-sm btn-warning">Редагувати</a>
                               
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Продуктів не знайдено.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        

        <div class="card-footer">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
       
    </section>

@endsection
