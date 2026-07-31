<?php
$dir = __DIR__;

// 1. Update AdminCategoryController for image
$categoryController = $dir . '/app/Http/Controllers/Admin/AdminCategoryController.php';
$catCode = <<<PHP
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
        \$request->validate(['name' => 'required', 'image' => 'nullable|image']);
        \$imagePath = null;
        if(\$request->hasFile('image')) {
            \$imagePath = \$request->file('image')->store('categories', 'public');
            \$imagePath = '/storage/' . \$imagePath;
        }
        Category::create([
            'name' => \$request->name,
            'slug' => Str::slug(\$request->name),
            'image' => \$imagePath
        ]);
        return back()->with('success', 'Category created with image.');
    }
    public function destroy(\$id) {
        Category::findOrFail(\$id)->delete();
        return back()->with('success', 'Category deleted.');
    }
}
PHP;
file_put_contents($categoryController, $catCode);

// Update categories view form
$catViewPath = $dir . '/resources/views/admin/categories.blade.php';
$catView = file_get_contents($catViewPath);
$catView = str_replace(
    '<form action="{{ route(\'admin.categories.store\') }}" method="POST">',
    '<form action="{{ route(\'admin.categories.store\') }}" method="POST" enctype="multipart/form-data">',
    $catView
);
$catView = str_replace(
    '<input type="text" name="name" class="form-control mb-3" placeholder="Category Name" required>',
    '<input type="text" name="name" class="form-control mb-3" placeholder="Category Name" required><input type="file" name="image" class="form-control mb-3">',
    $catView
);
file_put_contents($catViewPath, $catView);


// 2. Admin Blog Creation
// web.php update
$routesPath = $dir . '/routes/web.php';
$routesHtml = file_get_contents($routesPath);
if(!str_contains($routesHtml, "Route::get('/blogs/create'")) {
    $routesHtml = str_replace(
        "Route::get('/blogs/pending', [\App\Http\Controllers\Admin\AdminBlogController::class, 'pending'])->name('blogs.pending');",
        "Route::get('/blogs/pending', [\App\Http\Controllers\Admin\AdminBlogController::class, 'pending'])->name('blogs.pending');\n    Route::get('/blogs/create', [\App\Http\Controllers\Admin\AdminBlogController::class, 'create'])->name('blogs.create');\n    Route::post('/blogs', [\App\Http\Controllers\Admin\AdminBlogController::class, 'store'])->name('blogs.store');",
        $routesHtml
    );
    file_put_contents($routesPath, $routesHtml);
}

// AdminBlogController
$blogController = $dir . '/app/Http/Controllers/Admin/AdminBlogController.php';
$blogCode = <<<PHP
<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
    public function create() {
        \$categories = Category::all();
        return view('admin.blogs-create', compact('categories'));
    }
    public function store(Request \$request) {
        // Dummy store for admin (auto-approved)
        \$imagePath = "https://picsum.photos/seed/".rand(100,999)."/800/400";
        Blog::create([
            'user_id' => Auth::id() ?? 1,
            'category_id' => \$request->category_id,
            'title' => \$request->title,
            'slug' => Str::slug(\$request->title) . '-' . rand(1000, 9999),
            'content' => \$request->content,
            'excerpt' => Str::limit(strip_tags(\$request->content), 100),
            'featured_image' => \$imagePath,
            'status' => 'approved'
        ]);
        return redirect()->route('admin.dashboard')->with('success', 'Blog published instantly.');
    }
}
PHP;
file_put_contents($blogController, $blogCode);

// Admin blogs-create view
$blogCreateView = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Write Blog - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; color: #1E293B; }
        .sidebar { background: #0F172A; min-height: 100vh; color: white; padding-top: 20px; }
        .sidebar a { color: #cbd5e1; text-decoration: none; padding: 12px 20px; display: block; transition: 0.3s; }
        .sidebar a:hover { background: #1E293B; color: white; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar" style="width: 250px;">
            <h4 class="text-center fw-bold mb-4">Tindablog Admin</h4>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.blogs.pending') }}">Blogs (Pending)</a>
            <a href="{{ route('admin.blogs.create') }}" class="active">Write Blog</a>
            <a href="{{ route('admin.categories') }}">Categories</a>
            <a href="{{ route('admin.users') }}">Users</a>
            <a href="{{ route('admin.settings') }}">Settings</a>
        </div>
        <div class="flex-grow-1 p-5">
            <h2 class="fw-bold mb-4">Publish New Blog</h2>
            <form action="{{ route('admin.blogs.store') }}" method="POST">
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
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
    <script>tinymce.init({ selector: '#myeditor' });</script>
</body>
</html>
HTML;
file_put_contents($dir . '/resources/views/admin/blogs-create.blade.php', $blogCreateView);

// Add write link to sidebar
$dashboardPath = $dir . '/resources/views/admin/dashboard.blade.php';
$dashHtml = file_get_contents($dashboardPath);
if(!str_contains($dashHtml, 'Write Blog')) {
    $dashHtml = str_replace(
        '<a href="{{ route(\'admin.blogs.pending\') }}">Blogs (Pending)</a>',
        '<a href="{{ route(\'admin.blogs.pending\') }}">Blogs (Pending)</a><a href="{{ route(\'admin.blogs.create\') }}">Write Blog</a>',
        $dashHtml
    );
    file_put_contents($dashboardPath, $dashHtml);
}


// 3. Expanded Settings (Hero/Footer)
$settingsView = $dir . '/resources/views/admin/settings.blade.php';
$setHtml = file_get_contents($settingsView);
$setHtml = str_replace(
    '</form>',
    '<div class="mb-3"><label class="form-label fw-bold">Hero Background Image URL</label><input type="text" name="hero_image" class="form-control" value="{{ \$settings[\'hero_image\'] ?? \'https://images.unsplash.com/photo-1499750310107-5fef28a66643\' }}"></div>
    <div class="mb-3"><label class="form-label fw-bold">Facebook Link</label><input type="text" name="facebook" class="form-control" value="{{ \$settings[\'facebook\'] ?? \'\' }}"></div>
    <div class="mb-3"><label class="form-label fw-bold">Twitter Link</label><input type="text" name="twitter" class="form-control" value="{{ \$settings[\'twitter\'] ?? \'\' }}"></div>
    <div class="mb-3"><label class="form-label fw-bold">Instagram Link</label><input type="text" name="instagram" class="form-control" value="{{ \$settings[\'instagram\'] ?? \'\' }}"></div></form>',
    $setHtml
);
file_put_contents($settingsView, $setHtml);

// Update welcome.blade.php hero
$welcomeView = $dir . '/resources/views/welcome.blade.php';
$welHtml = file_get_contents($welcomeView);
$welHtml = preg_replace('/<section class="hero text-center text-white">/', '<section class="hero text-center text-white" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url(\'{{ \$settings[\'hero_image\'] ?? \'https://images.unsplash.com/photo-1499750310107-5fef28a66643\' }}\'); background-size: cover; background-position: center; padding: 100px 0;">', $welHtml);
file_put_contents($welcomeView, $welHtml);

echo "Expanded features applied.";
