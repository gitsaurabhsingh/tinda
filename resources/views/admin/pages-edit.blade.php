@extends('admin.layout')
@section('title', 'Edit Page')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Edit Custom Page</h2>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" name="title" class="form-control mb-3" value="{{ $page->title }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Header Image</label>
                    <input type="file" name="image" class="form-control mb-3" accept="image/*">
                    @if($page->image)
                        <small class="text-success"><i class="fa-solid fa-check-circle"></i> Image uploaded. Select new to replace.</small>
                    @endif
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select mb-3">
                        <option value="published" {{ $page->status === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ $page->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Content</label>
                <textarea id="myeditor" name="content" rows="15">{{ $page->content }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary px-4 fw-bold">Save Changes</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary px-4 ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<style>.tox-notifications-container { display: none !important; }</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({ 
    selector: '#myeditor',
    plugins: 'image link table lists code',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
});
</script>
@endsection
