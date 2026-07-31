<?php

$dir = __DIR__;
$webRoutes = $dir . '/routes/web.php';
$routesHtml = file_get_contents($webRoutes);
if(!str_contains($routesHtml, 'UserBlogController')) {
    $userRoutes = <<<PHP
    Route::get('/dashboard/blogs/create', [\App\Http\Controllers\UserBlogController::class, 'create'])->name('user.blogs.create');
    Route::post('/dashboard/blogs/store', [\App\Http\Controllers\UserBlogController::class, 'store'])->name('user.blogs.store');
PHP;
    $routesHtml = str_replace(
        "return view('dashboard');\n    })->name('dashboard');", 
        "return view('dashboard');\n    })->name('dashboard');\n" . $userRoutes, 
        $routesHtml
    );
    file_put_contents($webRoutes, $routesHtml);
}

$userBlogController = $dir . '/app/Http/Controllers/UserBlogController.php';
$controllerContent = <<<PHP
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;

class UserBlogController extends Controller {
    public function create() {
        \$categories = Category::all();
        return view('user.blogs.create', compact('categories'));
    }
    public function store(Request \$request) {
        // Dummy store logic for now
        return redirect()->route('dashboard')->with('success', 'Blog submitted for review.');
    }
}
PHP;
file_put_contents($userBlogController, $controllerContent);

$blogCreateDir = $dir . '/resources/views/user/blogs/';
if(!is_dir($blogCreateDir)) mkdir($blogCreateDir, 0777, true);

$blogCreateFile = $blogCreateDir . 'create.blade.php';
$blogCreateHtml = <<<HTML
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
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Category</label>
                    <select name="category_id" class="form-select" required>
                        @foreach(\$categories as \$category)
                            <option value="{{ \$category->id }}">{{ \$category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Featured Image</label>
                    <input type="file" name="image" class="form-control">
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
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#myeditor',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>
@endsection
HTML;
file_put_contents($blogCreateFile, $blogCreateHtml);

// Fix dashboard link to point to create blog
$dashboardFile = $dir . '/resources/views/dashboard.blade.php';
$dashboardHtml = file_get_contents($dashboardFile);
$dashboardHtml = str_replace('href="#" class="btn btn-primary', 'href="{{ route(\'user.blogs.create\') }}" class="btn btn-primary', $dashboardHtml);
$dashboardHtml = str_replace('href="#" class="btn btn-outline-primary', 'href="{{ route(\'user.blogs.create\') }}" class="btn btn-outline-primary', $dashboardHtml);
file_put_contents($dashboardFile, $dashboardHtml);

echo "Text Editor configured.";
