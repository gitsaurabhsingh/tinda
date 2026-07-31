@extends('admin.layout')
@section('title', 'Manage Pages')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">All Pages</h2>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Add New Page
    </a>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                <tr>
                    <td>
                        <strong>{{ $page->title }}</strong>
                        <br><small class="text-muted">{{ $page->slug }}</small>
                    </td>
                    <td>
                        @if($page->status == 'published') <span class="badge bg-success">Published</span>
                        @else <span class="badge bg-warning text-dark">Draft</span> @endif
                    </td>
                    <td>{{ $page->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="View"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4">No pages found. Start creating!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
