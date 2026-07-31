<?php
$dir = __DIR__;

// 1. Update web.php routes
$routesFile = $dir . '/routes/web.php';
$routesHtml = file_get_contents($routesFile);

$search = <<<PHP
    Route::get('/blogs/pending', function() { return view('admin.blogs'); })->name('blogs.pending');
    Route::get('/categories', function() { return view('admin.categories'); })->name('categories');
    Route::get('/users', function() { return view('admin.users'); })->name('users');
PHP;

$replace = <<<PHP
    Route::get('/blogs/pending', [\App\Http\Controllers\Admin\AdminBlogController::class, 'pending'])->name('blogs.pending');
    Route::post('/blogs/{id}/approve', [\App\Http\Controllers\Admin\AdminBlogController::class, 'approve'])->name('blogs.approve');
    Route::post('/blogs/{id}/reject', [\App\Http\Controllers\Admin\AdminBlogController::class, 'reject'])->name('blogs.reject');
    
    Route::get('/categories', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    
    Route::get('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('users.destroy');
PHP;

if(str_contains($routesHtml, "Route::get('/blogs/pending', function()")) {
    $routesHtml = str_replace($search, $replace, $routesHtml);
    file_put_contents($routesFile, $routesHtml);
}


// 2. Controllers Update
$controllerDir = $dir . '/app/Http/Controllers/Admin/';

// AdminCategoryController
file_put_contents($controllerDir . 'AdminCategoryController.php', <<<PHP
<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller {
    public function index() {
        \$categories = Category::all();
        return view('admin.categories', compact('categories'));
    }
    public function store(Request \$request) {
        \$request->validate(['name' => 'required']);
        Category::create([
            'name' => \$request->name,
            'slug' => Str::slug(\$request->name)
        ]);
        return back()->with('success', 'Category created.');
    }
    public function destroy(\$id) {
        Category::findOrFail(\$id)->delete();
        return back()->with('success', 'Category deleted.');
    }
}
PHP);

// AdminBlogController
file_put_contents($controllerDir . 'AdminBlogController.php', <<<PHP
<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Blog;

class AdminBlogController extends Controller {
    public function pending() {
        \$blogs = Blog::with('user', 'category')->where('status', 'pending')->get();
        return view('admin.blogs', compact('blogs'));
    }
    public function approve(\$id) {
        \$blog = Blog::findOrFail(\$id);
        \$blog->update(['status' => 'approved']);
        return back()->with('success', 'Blog approved successfully.');
    }
    public function reject(\$id) {
        \$blog = Blog::findOrFail(\$id);
        \$blog->update(['status' => 'rejected']);
        return back()->with('success', 'Blog rejected.');
    }
}
PHP);

// AdminUserController
file_put_contents($controllerDir . 'AdminUserController.php', <<<PHP
<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller {
    public function index() {
        \$users = User::all();
        return view('admin.users', compact('users'));
    }
    public function destroy(\$id) {
        User::findOrFail(\$id)->delete();
        return back()->with('success', 'User deleted.');
    }
}
PHP);

// 3. Views Update
// Categories View
$catView = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Categories - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <a href="{{ route('admin.blogs.pending') }}">Blogs (Pending)</a>
            <a href="{{ route('admin.categories') }}" class="active">Categories</a>
            <a href="{{ route('admin.users') }}">Users</a>
            <a href="{{ route('admin.settings') }}">Settings</a>
        </div>
        <div class="flex-grow-1 p-5">
            <h2 class="fw-bold mb-4">Categories Management</h2>
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="fw-bold">Add Category</h5>
                            <form action="{{ route('admin.categories.store') }}" method="POST">
                                @csrf
                                <input type="text" name="name" class="form-control mb-3" placeholder="Category Name" required>
                                <button type="submit" class="btn btn-primary w-100">Add</button>
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
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Delete</button>
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
        </div>
    </div>
</body>
</html>
HTML;
file_put_contents($dir . '/resources/views/admin/categories.blade.php', $catView);

// Blogs View
$blogView = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pending Blogs - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <a href="{{ route('admin.blogs.pending') }}" class="active">Blogs (Pending)</a>
            <a href="{{ route('admin.categories') }}">Categories</a>
            <a href="{{ route('admin.users') }}">Users</a>
            <a href="{{ route('admin.settings') }}">Settings</a>
        </div>
        <div class="flex-grow-1 p-5">
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
                                    <form action="{{ route('admin.blogs.approve', \$blog->id) }}" method="POST" class="d-inline">
                                        @csrf <button class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.blogs.reject', \$blog->id) }}" method="POST" class="d-inline">
                                        @csrf <button class="btn btn-sm btn-danger">Reject</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4">No pending blogs to review.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
file_put_contents($dir . '/resources/views/admin/blogs.blade.php', $blogView);

// Users View
$userView = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <a href="{{ route('admin.blogs.pending') }}">Blogs (Pending)</a>
            <a href="{{ route('admin.categories') }}">Categories</a>
            <a href="{{ route('admin.users') }}" class="active">Users</a>
            <a href="{{ route('admin.settings') }}">Settings</a>
        </div>
        <div class="flex-grow-1 p-5">
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
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
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
</body>
</html>
HTML;
file_put_contents($dir . '/resources/views/admin/users.blade.php', $userView);

echo "Admin CRUD implemented successfully.";
