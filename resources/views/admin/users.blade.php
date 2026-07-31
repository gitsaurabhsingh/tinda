@extends('admin.layout')
@section('title', 'Users')
@section('content')
<h2 class="fw-bold mb-4">User Management</h2>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table align-middle">
            <thead class="table-light"><tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr></thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?');">
                            @csrf @method('DELETE') <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection