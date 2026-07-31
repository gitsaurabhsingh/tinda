@extends('admin.layout')
@section('title', 'Edit Category')
@section('content')
<h2 class="fw-bold mb-4">Edit Category</h2>
<div class="card shadow-sm border-0" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label fw-bold">Category Name</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Category Image</label>
                @if($category->image)
                    <div class="mb-2">
                        <img src="{{ $category->image }}" alt="Current Image" class="rounded border" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Leave blank to keep the current image.</small>
            </div>
            
            <button type="submit" class="btn btn-primary px-4 fw-bold">Update Category</button>
            <a href="{{ route('admin.categories') }}" class="btn btn-outline-secondary ms-2 px-4">Cancel</a>
        </form>
    </div>
</div>
@endsection
