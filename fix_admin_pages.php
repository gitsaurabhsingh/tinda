<?php
$dir = __DIR__;

// Create the views
$views = [
    'blogs' => [
        'title' => 'Pending Blogs',
        'content' => '<h2 class="fw-bold mb-4">Pending Blogs</h2><div class="alert alert-info">No pending blogs to review.</div>'
    ],
    'categories' => [
        'title' => 'Categories',
        'content' => '<h2 class="fw-bold mb-4">Categories</h2><div class="alert alert-secondary">Categories list will appear here.</div>'
    ],
    'users' => [
        'title' => 'Users',
        'content' => '<h2 class="fw-bold mb-4">Users</h2><div class="alert alert-secondary">Registered users will appear here.</div>'
    ]
];

foreach ($views as $key => $data) {
    $activeDashboard = $key == 'dashboard' ? 'active' : '';
    $activeBlogs = $key == 'blogs' ? 'active' : '';
    $activeCategories = $key == 'categories' ? 'active' : '';
    $activeUsers = $key == 'users' ? 'active' : '';
    $activeSettings = $key == 'settings' ? 'active' : '';

    $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$data['title']} - Admin</title>
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
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.blogs.pending') }}" class="{$activeBlogs}">Blogs (Pending)</a>
            <a href="{{ route('admin.categories') }}" class="{$activeCategories}">Categories</a>
            <a href="{{ route('admin.users') }}" class="{$activeUsers}">Users</a>
            <a href="{{ route('admin.settings') }}">Settings</a>
            <a href="/" class="mt-5 text-warning">&larr; Back to Site</a>
        </div>
        
        <div class="flex-grow-1 p-5">
            {$data['content']}
        </div>
    </div>
</body>
</html>
HTML;
    file_put_contents($dir . '/resources/views/admin/' . $key . '.blade.php', $html);
}

// Update routes
$routesFile = $dir . '/routes/web.php';
$routesHtml = file_get_contents($routesFile);

$search = <<<PHP
    Route::get('/blogs/pending', function() {
        return "<h2>Pending Blogs List</h2><a href='/admin'>Back</a>";
    })->name('blogs.pending');
    
    Route::get('/categories', function() {
        return "<h2>Categories List</h2><a href='/admin'>Back</a>";
    })->name('categories');
    
    Route::get('/users', function() {
        return "<h2>Users List</h2><a href='/admin'>Back</a>";
    })->name('users');
PHP;

$replace = <<<PHP
    Route::get('/blogs/pending', function() { return view('admin.blogs'); })->name('blogs.pending');
    Route::get('/categories', function() { return view('admin.categories'); })->name('categories');
    Route::get('/users', function() { return view('admin.users'); })->name('users');
PHP;

$routesHtml = str_replace($search, $replace, $routesHtml);
file_put_contents($routesFile, $routesHtml);

echo "Admin pages fixed.";
