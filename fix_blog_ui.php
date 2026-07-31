<?php
$dir = __DIR__;

// 1. Fix Blog Model Fillable
$blogModel = $dir . '/app/Models/Blog.php';
$blogCode = file_get_contents($blogModel);
if (!str_contains($blogCode, "'gallery_images'")) {
    $blogCode = str_replace(
        "'seo_description'",
        "'seo_description', 'gallery_images'",
        $blogCode
    );
    file_put_contents($blogModel, $blogCode);
}

// 2. Update AdminBlogController to pass all blogs
$adminBlogController = $dir . '/app/Http/Controllers/Admin/AdminBlogController.php';
$adminCode = file_get_contents($adminBlogController);
$adminCode = str_replace(
    "return view('admin.blogs-create', compact('categories'));",
    "\$all_blogs = Blog::with('category')->latest()->get();\n        return view('admin.blogs-create', compact('categories', 'all_blogs'));",
    $adminCode
);
// Also redirect to back instead of dashboard after saving
$adminCode = str_replace(
    "return redirect()->route('admin.dashboard')->with('success', 'Blog published instantly.');",
    "return back()->with('success', 'Blog published successfully.');",
    $adminCode
);
file_put_contents($adminBlogController, $adminCode);

// 3. Update blogs-create.blade.php UI
$createView = $dir . '/resources/views/admin/blogs-create.blade.php';
$createHtml = file_get_contents($createView);

$newUi = <<<HTML
@extends('admin.layout')
@section('title', 'Manage Blogs')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">All Published Blogs</h2>
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#addBlogCollapse">
        + Add New Blog
    </button>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

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
                    </div>
                    <div class="col-md-4">
                        <select name="category_id" class="form-select mb-3">
                            @foreach(\$categories as \$cat) <option value="{{ \$cat->id }}">{{ \$cat->name }}</option> @endforeach
                        </select>
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
                @forelse(\$all_blogs as \$blog)
                <tr>
                    <td>
                        <strong>{{ \$blog->title }}</strong>
                        <br><small class="text-muted">{{ \$blog->slug }}</small>
                    </td>
                    <td><span class="badge bg-secondary">{{ \$blog->category->name ?? 'Uncategorized' }}</span></td>
                    <td>
                        @if(\$blog->status == 'approved') <span class="badge bg-success">Live</span>
                        @elseif(\$blog->status == 'pending') <span class="badge bg-warning text-dark">Pending</span>
                        @else <span class="badge bg-danger">Rejected</span> @endif
                    </td>
                    <td>{{ \$blog->views }}</td>
                    <td>{{ \$blog->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('blog.show', \$blog->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
<script>
function checkFiles(input) { 
    if(input.files.length > 5) { 
        alert("You can only upload a maximum of 5 images."); 
        input.value = ""; 
    } 
}
tinymce.init({ selector: '#myeditor' });
</script>
@endsection
HTML;
file_put_contents($createView, $newUi);

// 4. Update the sidebar link text from "Write Blog (Admin)" to "Manage Blogs"
$layoutBlade = $dir . '/resources/views/admin/layout.blade.php';
$layoutHtml = file_get_contents($layoutBlade);
$layoutHtml = str_replace(
    '>Write Blog (Admin)</a>',
    '>Manage Blogs</a>',
    $layoutHtml
);
file_put_contents($layoutBlade, $layoutHtml);

echo "Admin Blog page updated.";
