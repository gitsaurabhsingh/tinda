@extends('admin.layout')
@section('title', 'Manage Pages')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0 text-dark">Manage Pages</h2>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary fw-bold" style="border-radius: 10px;">
            <i class="fa-solid fa-plus me-2"></i> Create Page
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary fw-bold border-0">Title</th>
                        <th class="px-4 py-3 text-secondary fw-bold border-0">Slug</th>
                        <th class="px-4 py-3 text-secondary fw-bold border-0 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($pages as $page)
                    <tr>
                        <td class="px-4 py-3 fw-medium">{{ $page->title }}</td>
                        <td class="px-4 py-3 text-muted">/{{ $page->slug }}</td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2">Edit</a>
                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Are you sure you want to delete this page?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-5 text-center text-muted">
                            <div class="mb-3"><i class="fa-solid fa-file-lines fs-1 text-light"></i></div>
                            No pages found. Create one to get started!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pages->hasPages())
        <div class="card-footer bg-white border-top p-4">
            {{ $pages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
