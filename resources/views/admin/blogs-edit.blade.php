@extends('admin.layout')
@section('title', 'Edit Blog')
@section('content')
<h2 class="fw-bold mb-4">Edit Blog</h2>
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
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
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="approved" {{ $blog->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ $blog->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ $blog->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Update Images (Max 5)</label>
                @php
                    $gallery = !empty($blog->gallery_images) ? json_decode($blog->gallery_images) : [];
                @endphp
                
                @if(!empty($gallery))
                    <div class="mb-3">
                        <small class="text-muted d-block mb-2">Currently Uploaded Images (First is Featured):</small>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($gallery as $index => $img)
                                <div class="position-relative border rounded shadow-sm overflow-hidden" style="width: 80px; height: 80px;" id="existing-img-{{ $index }}">
                                    <img src="{{ $img }}" class="w-100 h-100" style="object-fit: cover; background-color: #f8fafc;">
                                    @if($index === 0)
                                        <span class="position-absolute bottom-0 start-0 w-100 text-center bg-primary text-white" style="font-size: 0.6rem; padding: 2px 0;">Featured</span>
                                    @endif
                                    <button type="button" class="position-absolute top-0 end-0 btn btn-sm btn-danger p-0 d-flex align-items-center justify-content-center" style="width: 18px; height: 18px; font-size: 12px; border-radius: 0 0 0 4px;" onclick="removeExistingImage({{ $index }}, '{{ $img }}')">&times;</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($blog->featured_image && $blog->featured_image !== '')
                    <div class="mb-3">
                        <small class="text-muted d-block mb-2">Current Featured Image:</small>
                        <div class="position-relative border rounded shadow-sm overflow-hidden" style="width: 80px; height: 80px;" id="existing-featured-img">
                            <img src="{{ $blog->featured_image }}" class="w-100 h-100" style="object-fit: cover; background-color: #f8fafc;">
                            <button type="button" class="position-absolute top-0 end-0 btn btn-sm btn-danger p-0 d-flex align-items-center justify-content-center" style="width: 18px; height: 18px; font-size: 12px; border-radius: 0 0 0 4px;" onclick="removeFeaturedImage('{{ $blog->featured_image }}')">&times;</button>
                        </div>
                    </div>
                @endif
                
                <input type="file" name="images[]" class="form-control" multiple accept="image/*" id="galleryUpload" onchange="checkFiles(this)">
                <small class="text-muted">Leave empty to keep existing images. Uploading new images will replace the entire current gallery.</small>
                
                <!-- Container for live preview of newly selected images -->
                <div id="imagePreviewContainer" class="d-flex flex-wrap gap-2 mt-3"></div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Content</label>
                <textarea id="myeditor" name="content" rows="15">{{ $blog->content }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary px-4 fw-bold">Save Changes</button>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary px-4 ms-2">Cancel</a>
        </form>
    </div>
</div>

<style>.tox-notifications-container { display: none !important; }</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
let selectedFiles = new DataTransfer();

function checkFiles(input) { 
    const previewContainer = document.getElementById('imagePreviewContainer');
    
    // Add new files to our DataTransfer object
    Array.from(input.files).forEach(file => {
        if(selectedFiles.items.length < 5) {
            selectedFiles.items.add(file);
        } else {
            alert("You can only upload a maximum of 5 images. Extra images were ignored.");
        }
    });
    
    // Update the input with our cumulative files
    input.files = selectedFiles.files;
    
    // Clear previous previews
    previewContainer.innerHTML = ''; 

    // Generate previews for each selected file
    Array.from(input.files).forEach((file, index) => {
        if (!file.type.match('image.*')) return;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.className = 'position-relative border rounded shadow-sm overflow-hidden border-primary';
            wrapper.style.width = '80px';
            wrapper.style.height = '80px';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-100 h-100';
            img.style.objectFit = 'cover';
            
            if (index === 0) {
                const badge = document.createElement('span');
                badge.className = 'position-absolute bottom-0 start-0 w-100 text-center bg-primary text-white';
                badge.style.fontSize = '0.6rem';
                badge.style.padding = '2px 0';
                badge.innerText = 'New Featured';
                wrapper.appendChild(badge);
            }

            // Add a remove button
            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '&times;';
            removeBtn.className = 'position-absolute top-0 end-0 btn btn-sm btn-danger p-0 d-flex align-items-center justify-content-center';
            removeBtn.style.width = '18px';
            removeBtn.style.height = '18px';
            removeBtn.style.fontSize = '12px';
            removeBtn.style.borderRadius = '0 0 0 4px';
            removeBtn.onclick = function(ev) {
                ev.preventDefault();
                removeFile(index, input);
            };
            
            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            previewContainer.appendChild(wrapper);
        }
        reader.readAsDataURL(file);
    });
}

function removeFile(indexToRemove, inputElement) {
    const dt = new DataTransfer();
    Array.from(selectedFiles.files).forEach((file, i) => {
        if(i !== indexToRemove) {
            dt.items.add(file);
        }
    });
    selectedFiles = dt;
    inputElement.files = selectedFiles.files;
    checkFiles(inputElement); // Refresh UI
}

function removeExistingImage(index, imgUrl) {
    const element = document.getElementById('existing-img-' + index);
    if (element) {
        element.style.display = 'none';
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remove_existing_images[]';
        input.value = imgUrl;
        document.forms[0].appendChild(input);
    }
}

function removeFeaturedImage(imgUrl) {
    const element = document.getElementById('existing-featured-img');
    if (element) {
        element.style.display = 'none';
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remove_existing_images[]';
        input.value = imgUrl;
        document.forms[0].appendChild(input);
    }
}
</script>
<script>
  tinymce.init({
    selector: '#myeditor',
    plugins: 'image anchor autolink charmap codesample emoticons link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    image_title: true,
    automatic_uploads: true,
    images_upload_handler: function (blobInfo, progress) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route('admin.blogs.upload-image') }}');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            
            xhr.upload.onprogress = (e) => { progress(e.loaded / e.total * 100); };
            
            xhr.onload = () => {
                if (xhr.status < 200 || xhr.status >= 300) { reject('HTTP Error: ' + xhr.status); return; }
                const json = JSON.parse(xhr.responseText);
                if (!json || typeof json.location != 'string') { reject('Invalid JSON: ' + xhr.responseText); return; }
                resolve(json.location);
            };
            
            xhr.onerror = () => reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        });
    }
  });
</script>
@endsection
