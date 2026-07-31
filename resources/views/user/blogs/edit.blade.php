@extends('layouts.app')
@section('title', 'Edit Blog - Tindablog')
@section('content')
<div class="container py-5 mt-4">
    <h2 class="fw-bold mb-4">Edit Blog</h2>
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <form action="{{ route('user.blogs.update', $blog->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label fw-bold">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $blog->title }}" required>
                @error('title')
                    <div class="text-danger mt-1 small"><i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}</div>
                @enderror
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold mb-2">Categories</label>
                    <div class="border rounded p-2" style="max-height: 150px; overflow-y: auto;">
                        @foreach($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="category_ids[]" value="{{ $category->id }}" id="cat_{{ $category->id }}" {{ in_array($category->id, $blog->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat_{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Content</label>
                <!-- TinyMCE Integration -->
                <textarea id="myeditor" name="content" rows="15">{{ $blog->content }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">Save Changes</button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 ms-2">Cancel</a>
        </form>
    </div>
</div>

<!-- TinyMCE Script -->
<style>.tox-notifications-container { display: none !important; }</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#myeditor',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>
@endsection
