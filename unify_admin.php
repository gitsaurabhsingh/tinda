<?php
$dir = __DIR__;
$adminDir = $dir . '/resources/views/admin/';

// 1. Create layout.blade.php
$layoutHtml = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tindablog Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; color: #1E293B; }
        .sidebar { background: #0F172A; min-height: 100vh; color: white; padding-top: 20px; }
        .sidebar a { color: #cbd5e1; text-decoration: none; padding: 12px 20px; display: block; transition: 0.3s; }
        .sidebar a:hover { background: #1E293B; color: white; }
        .sidebar .active { background: #2563EB; color: white; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar" style="width: 250px;">
            <h4 class="text-center fw-bold mb-4">Tindablog Admin</h4>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.blogs.pending') }}" class="{{ request()->routeIs('admin.blogs.pending') ? 'active' : '' }}">Blogs (Pending)</a>
            <a href="{{ route('admin.blogs.create') }}" class="{{ request()->routeIs('admin.blogs.create') ? 'active' : '' }}">Write Blog (Admin)</a>
            <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories') ? 'active' : '' }}">Categories</a>
            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">Users</a>
            <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">Hero & Footer Settings</a>
            <a href="/" class="mt-5 text-warning" target="_blank">&larr; View Live Site</a>
        </div>
        
        <div class="flex-grow-1 p-5">
            @yield('content')
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>
HTML;
file_put_contents($adminDir . 'layout.blade.php', $layoutHtml);

// 2. Refactor Views
// Dashboard
$dashboardHtml = <<<HTML
@extends('admin.layout')
@section('title', 'Admin Dashboard')
@section('content')
<h2 class="fw-bold mb-4">Dashboard Overview</h2>
<div class="row mb-5">
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-4 p-3">
            <h6 class="text-muted fw-bold">Total Blogs</h6><h3 class="fw-bold">{{ \$stats['total_blogs'] }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-4 p-3">
            <h6 class="text-muted fw-bold">Pending Review</h6><h3 class="fw-bold text-warning">{{ \$stats['pending_blogs'] }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-4 p-3">
            <h6 class="text-muted fw-bold">Total Users</h6><h3 class="fw-bold text-primary">{{ \$stats['total_users'] }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-4 p-3">
            <h6 class="text-muted fw-bold">Comments</h6><h3 class="fw-bold text-success">{{ \$stats['total_comments'] }}</h3>
        </div>
    </div>
</div>
@endsection
HTML;
file_put_contents($adminDir . 'dashboard.blade.php', $dashboardHtml);

// Blogs Pending
$blogsHtml = <<<HTML
@extends('admin.layout')
@section('title', 'Pending Blogs')
@section('content')
<h2 class="fw-bold mb-4">Pending Blogs Approval</h2>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table align-middle">
            <thead class="table-light"><tr><th>Title</th><th>Author</th><th>Category</th><th>Action</th></tr></thead>
            <tbody>
                @forelse(\$blogs as \$blog)
                <tr>
                    <td>{{ \$blog->title }}</td>
                    <td>{{ \$blog->user->name ?? 'Unknown' }}</td>
                    <td>{{ \$blog->category->name ?? 'Unknown' }}</td>
                    <td>
                        <form action="{{ route('admin.blogs.approve', \$blog->id) }}" method="POST" class="d-inline">@csrf <button class="btn btn-sm btn-success">Approve</button></form>
                        <form action="{{ route('admin.blogs.reject', \$blog->id) }}" method="POST" class="d-inline">@csrf <button class="btn btn-sm btn-danger">Reject</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4">No pending blogs to review.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
HTML;
file_put_contents($adminDir . 'blogs.blade.php', $blogsHtml);

// Blogs Create
$blogsCreateHtml = <<<HTML
@extends('admin.layout')
@section('title', 'Write Blog')
@section('content')
<h2 class="fw-bold mb-4">Publish New Blog (Admin)</h2>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="title" class="form-control mb-3" placeholder="Blog Title" required>
            <select name="category_id" class="form-select mb-3">
                @foreach(\$categories as \$cat) <option value="{{ \$cat->id }}">{{ \$cat->name }}</option> @endforeach
            </select>
            <textarea id="myeditor" name="content" rows="10"></textarea>
            <button type="submit" class="btn btn-success mt-4">Publish Now</button>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
<script>tinymce.init({ selector: '#myeditor' });</script>
@endsection
HTML;
file_put_contents($adminDir . 'blogs-create.blade.php', $blogsCreateHtml);

// Categories
$catHtml = <<<HTML
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
                        @foreach(\$categories as \$category)
                        <tr>
                            <td>{{ \$category->id }}</td>
                            <td>{{ \$category->name }}</td>
                            <td>{{ \$category->slug }}</td>
                            <td>
                                <form action="{{ route('admin.categories.destroy', \$category->id) }}" method="POST" class="d-inline">
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
HTML;
file_put_contents($adminDir . 'categories.blade.php', $catHtml);

// Users
$usersHtml = <<<HTML
@extends('admin.layout')
@section('title', 'Users')
@section('content')
<h2 class="fw-bold mb-4">User Management</h2>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table align-middle">
            <thead class="table-light"><tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr></thead>
            <tbody>
                @foreach(\$users as \$user)
                <tr>
                    <td>{{ \$user->id }}</td>
                    <td>{{ \$user->name }}</td>
                    <td>{{ \$user->email }}</td>
                    <td>
                        <form action="{{ route('admin.users.destroy', \$user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?');">
                            @csrf @method('DELETE') <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
HTML;
file_put_contents($adminDir . 'users.blade.php', $usersHtml);

// Settings
$settingsHtml = <<<HTML
@extends('admin.layout')
@section('title', 'Settings')
@section('content')
<h2 class="fw-bold mb-4">Hero Banner & Footer Settings</h2>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <h5 class="fw-bold text-primary mb-3">Navbar & General</h5>
            <div class="mb-3">
                <label class="form-label fw-bold">Site Name (Navbar)</label>
                <input type="text" name="site_name" class="form-control" value="{{ \$settings['site_name'] ?? '' }}">
            </div>
            
            <hr class="my-4">
            <h5 class="fw-bold text-primary mb-3">Hero Banner Settings</h5>
            <div class="mb-3">
                <label class="form-label fw-bold">Hero Background Image URL</label>
                <input type="text" name="hero_image" class="form-control" value="{{ \$settings['hero_image'] ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643' }}">
                <small class="text-muted">Paste an image link here to change the homepage banner.</small>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Hero Banner Title</label>
                <input type="text" name="hero_title" class="form-control" value="{{ \$settings['hero_title'] ?? '' }}">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Hero Banner Subtitle</label>
                <input type="text" name="hero_subtitle" class="form-control" value="{{ \$settings['hero_subtitle'] ?? '' }}">
            </div>
            
            <hr class="my-4">
            <h5 class="fw-bold text-primary mb-3">Footer & Social Settings</h5>
            <div class="mb-3">
                <label class="form-label fw-bold">Footer About Text</label>
                <textarea name="footer_text" class="form-control" rows="3">{{ \$settings['footer_text'] ?? '' }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Facebook Link</label>
                    <input type="text" name="facebook" class="form-control" value="{{ \$settings['facebook'] ?? '' }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Twitter Link</label>
                    <input type="text" name="twitter" class="form-control" value="{{ \$settings['twitter'] ?? '' }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Instagram Link</label>
                    <input type="text" name="instagram" class="form-control" value="{{ \$settings['instagram'] ?? '' }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg mt-4 px-5 fw-bold rounded-pill">Save All Settings</button>
        </form>
    </div>
</div>
@endsection
HTML;
file_put_contents($adminDir . 'settings.blade.php', $settingsHtml);

echo "Admin UI unified.";
