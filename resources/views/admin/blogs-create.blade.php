@extends('admin.layout')
@section('title', 'Manage Blogs')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">All Published Blogs</h2>
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#addBlogCollapse" aria-expanded="false" aria-controls="addBlogCollapse">
        <i class="fa-solid fa-plus me-2"></i> Add New Blog
    </button>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Add New Blog Form (Hidden by default) -->
<div class="collapse mb-5" id="addBlogCollapse">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Publish New Blog</h4>
            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" name="title" class="form-control mb-3" placeholder="Blog Title" required>
                                @error('title')
                                    <div class="text-danger mt-1 small"><i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}</div>
                                @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold mb-2">Categories</label>
                        <input type="text" id="categorySearch" class="form-control form-control-sm mb-2" placeholder="Search categories...">
                        <div class="border rounded p-2" id="categoryContainer" style="max-height: 150px; overflow-y: auto;">
                            @foreach($categories as $cat)
                                <div class="form-check category-item">
                                    <input class="form-check-input category-checkbox" type="checkbox" name="category_ids[]" value="{{ $cat->id }}" id="cat_{{ $cat->id }}">
                                    <label class="form-check-label category-label" for="cat_{{ $cat->id }}">{{ $cat->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="prevCatPage" disabled>Prev</button>
                            <span id="catPageInfo" class="small text-muted align-self-center"></span>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="nextCatPage">Next</button>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold mt-2">Upload Images (Max 5)</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*" onchange="checkFiles(this)">
                </div>

                <textarea id="myeditor" name="content" rows="15"></textarea>
                <button type="submit" class="btn btn-success btn-lg mt-4 w-100 fw-bold">Publish Now</button>
            </form>
        </div>
    </div>
</div>

<!-- All Blogs Table -->
<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($all_blogs as $blog)
                <tr>
                    <td>
                        <strong>{{ $blog->title }}</strong>
                        <br><small class="text-muted">{{ $blog->slug }}</small>
                    </td>
                    <td><span class="badge bg-secondary">{{ $blog->categories->first()->name ?? 'Uncategorized' ?? 'Uncategorized' }}</span></td>
                    <td>
                        @if($blog->status == 'approved') <span class="badge bg-success">Live</span>
                        @elseif($blog->status == 'pending') <span class="badge bg-warning text-dark">Pending</span>
                        @else <span class="badge bg-danger">Rejected</span> @endif
                    </td>
                    <td>{{ $blog->views }}</td>
                    <td>{{ $blog->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('page.show', $blog->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="View"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4">No blogs found. Start writing!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<style>.tox-notifications-container { display: none !important; }</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
let selectedFiles = new DataTransfer();

function checkFiles(input) { 
    const previewContainer = document.getElementById('imagePreviewContainer');
    if (!previewContainer) {
        // Create container if it doesn't exist in create page
        const container = document.createElement('div');
        container.id = 'imagePreviewContainer';
        container.className = 'd-flex flex-wrap gap-2 mt-3';
        input.parentNode.appendChild(container);
    }
    const pc = document.getElementById('imagePreviewContainer');
    
    // Add new files
    Array.from(input.files).forEach(file => {
        if(selectedFiles.items.length < 5) {
            selectedFiles.items.add(file);
        } else {
            alert("You can only upload a maximum of 5 images. Extra images were ignored.");
        }
    });
    
    // Update input
    input.files = selectedFiles.files;
    
    // Clear previous previews
    pc.innerHTML = ''; 

    // Generate previews
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
                badge.innerText = 'Featured';
                wrapper.appendChild(badge);
            }

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
            pc.appendChild(wrapper);
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
    checkFiles(inputElement); 
}
</script>
<script>
tinymce.init({ 
    selector: '#myeditor',
    plugins: 'image link table lists code',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
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
    },
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('categorySearch');
    const items = Array.from(document.querySelectorAll('.category-item'));
    const prevBtn = document.getElementById('prevCatPage');
    const nextBtn = document.getElementById('nextCatPage');
    const infoSpan = document.getElementById('catPageInfo');
    
    let currentPage = 1;
    const itemsPerPage = 10;
    let filteredItems = [...items];
    
    function renderPagination() {
        const totalPages = Math.ceil(filteredItems.length / itemsPerPage) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        
        // Hide all first
        items.forEach(item => item.style.display = 'none');
        
        // Show only current page of filtered items
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        
        filteredItems.slice(start, end).forEach(item => {
            item.style.display = 'block';
        });
        
        // Update buttons and info
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage >= totalPages;
        infoSpan.textContent = `Page ${currentPage} of ${totalPages}`;
    }
    
    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase();
        filteredItems = items.filter(item => {
            const text = item.querySelector('.category-label').textContent.toLowerCase();
            return text.includes(term);
        });
        currentPage = 1; // reset to first page on search
        renderPagination();
    });
    
    prevBtn.addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            renderPagination();
        }
    });
    
    nextBtn.addEventListener('click', function() {
        const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderPagination();
        }
    });
    
    // Initial render
    renderPagination();
});
</script>
@endsection
