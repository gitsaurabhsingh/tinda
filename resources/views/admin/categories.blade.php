@extends('admin.layout')
@section('title', 'Categories')
@section('content')
<h2 class="fw-bold mb-4">Categories Management</h2>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold">Add Category</h5>
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="name" class="form-control mb-3" placeholder="Category Name" required>
                    <input type="file" name="image" class="form-control mb-3">
                    <button type="submit" class="btn btn-primary w-100">Add Category</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table align-middle">
                    <thead class="table-light"><tr><th>ID</th><th>Name</th><th>Slug</th><th>Action</th></tr></thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?');">
                                    @csrf @method('DELETE') <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection