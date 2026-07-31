@extends('admin.layout')
@section('title', 'Pending Blogs')
@section('content')
<h2 class="fw-bold mb-4">Manage All Blogs</h2>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light"><tr><th>Title</th><th>Author</th><th>Category</th><th>Status</th><th class="text-end">Action</th></tr></thead>
            <tbody>
                @forelse($blogs as $blog)
                <tr>
                    <td>{{ $blog->title }}</td>
                    <td>{{ $blog->user->name ?? 'Unknown' }}</td>
                    <td>{{ $blog->categories->first()->name ?? 'Uncategorized' ?? 'Unknown' }}</td>
                    <td>
                        @if($blog->status === 'approved') <span class="badge bg-success">Approved</span>
                        @elseif($blog->status === 'rejected') <span class="badge bg-danger">Rejected</span>
                        @else <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        @if($blog->status !== 'approved')
                        <form action="{{ route('admin.blogs.approve', $blog->id) }}" method="POST" class="d-inline">@csrf <button class="btn btn-sm btn-success">Approve</button></form>
                        @endif
                        @if($blog->status !== 'rejected')
                        <form action="{{ route('admin.blogs.reject', $blog->id) }}" method="POST" class="d-inline">@csrf <button class="btn btn-sm btn-warning">Reject</button></form>
                        @endif
                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog?');">@csrf @method('DELETE') <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4">No blogs found.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection