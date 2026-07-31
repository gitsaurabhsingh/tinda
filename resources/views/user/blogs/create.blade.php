@extends('layouts.app')

@section('title', 'Write New Blog - Tindablog')

@section('content')
<div class="container py-5 mt-4">
    <h2 class="fw-bold mb-4">Write a New Blog</h2>
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <form action="{{ route('user.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Title</label>
                <input type="text" name="title" class="form-control" required>
                                @error('title')
                                    <div class="text-danger mt-1 small"><i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}</div>
                                @enderror
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold mb-2">Categories</label>
                    <div class="border rounded p-2" style="max-height: 150px; overflow-y: auto;">
                        @foreach($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="category_ids[]" value="{{ $category->id }}" id="cat_{{ $category->id }}">
                                <label class="form-check-label" for="cat_{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Featured Image / Gallery</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*" id="userImageUpload" onchange="checkUserFiles(this)">
                    <small class="text-muted d-block mb-2">You can select up to 5 images. The first image will be the Featured cover.</small>
                    <!-- Live Image Preview Gallery -->
                    <div id="imagePreviewContainer" class="d-flex flex-wrap gap-2 mt-3"></div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Content</label>
                <!-- TinyMCE Integration -->
                <textarea id="myeditor" name="content" rows="15"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">Submit for Review</button>
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
<script>
function checkUserFiles(input) { 
    const previewContainer = document.getElementById('imagePreviewContainer');
    previewContainer.innerHTML = ''; // Clear previous previews

    if(input.files.length > 5) { 
        alert("You can only upload a maximum of 5 images."); 
        input.value = ""; 
        return;
    }

    // Generate previews for each selected file
    Array.from(input.files).forEach((file, index) => {
        if (!file.type.match('image.*')) return;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.className = 'position-relative border rounded shadow-sm overflow-hidden';
            wrapper.style.width = '100px';
            wrapper.style.height = '100px';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-100 h-100 object-fit-cover';
            
            // Add a "Featured" badge to the first image
            if (index === 0) {
                const badge = document.createElement('span');
                badge.className = 'position-absolute bottom-0 start-0 w-100 text-center bg-primary text-white"';
                badge.style.fontSize = '0.65rem';
                badge.style.padding = '2px 0';
                badge.innerText = 'Featured';
                wrapper.appendChild(badge);
            }

            wrapper.appendChild(img);
            previewContainer.appendChild(wrapper);
        }
        reader.readAsDataURL(file);
    });
}
</script>
@endsection