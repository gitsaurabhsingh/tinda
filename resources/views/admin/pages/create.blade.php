@extends('admin.layout')
@section('title', 'Create Page')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0 text-dark">Create New Page</h2>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary fw-bold" style="border-radius: 10px;">
            <i class="fa-solid fa-arrow-left me-2"></i> Back to Pages
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-bold">Page Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control form-control-lg bg-light border-0 @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Slug (Optional)</label>
                    <input type="text" name="slug" class="form-control form-control-lg bg-light border-0 @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="Leave blank to auto-generate from title">
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Featured Image (Optional)</label>
                    <input type="file" name="image" class="form-control form-control-lg bg-light border-0 @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Page Content</label>
                    <textarea name="content" id="editor" class="form-control bg-light border-0 @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Meta Description</label>
                    <textarea name="meta_description" class="form-control bg-light border-0 @error('meta_description') is-invalid @enderror" rows="3">{{ old('meta_description') }}</textarea>
                    @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex justify-content-end mt-5 border-top pt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5" style="border-radius: 10px;">Create Page</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include Summernote or TinyMCE for rich text editor if available. For now using basic textarea that accepts HTML -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
<style>
    .ck-editor__editable_inline { min-height: 400px; }
</style>
@endsection
