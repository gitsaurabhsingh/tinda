<?php
$dir = __DIR__;

$routesFile = $dir . '/routes/web.php';
$routesHtml = file_get_contents($routesFile);
if(!str_contains($routesHtml, 'AdminCategoryController')) {
    $adminRoutes = <<<PHP
    Route::get('/categories', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'index'])->name('categories');
    Route::get('/blogs/pending', [\App\Http\Controllers\Admin\AdminBlogController::class, 'pending'])->name('blogs.pending');
    Route::get('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users');
PHP;
    $routesHtml = str_replace(
        "Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');", 
        "Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');\n" . $adminRoutes, 
        $routesHtml
    );
    file_put_contents($routesFile, $routesHtml);
}

// 2. Admin Controllers (Stubs)
$controllerDir = $dir . '/app/Http/Controllers/Admin/';
file_put_contents($controllerDir . 'AdminCategoryController.php', <<<PHP
<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
class AdminCategoryController extends Controller {
    public function index() {
        \$categories = Category::all();
        return view('admin.categories', compact('categories'));
    }
}
PHP
);

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
}
PHP
);

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
}
PHP
);

// 3. Update Sidebars
$views = [
    $dir . '/resources/views/admin/dashboard.blade.php',
    $dir . '/resources/views/admin/settings.blade.php'
];

foreach ($views as \$view) {
    if(file_exists(\$view)) {
        \$content = file_get_contents(\$view);
        \$content = preg_replace('/<a href=".*?">Blogs \(Pending\)<\/a>/', '<a href="{{ route(\'admin.blogs.pending\') }}">Blogs (Pending)</a>', \$content);
        \$content = preg_replace('/<a href=".*?">Categories<\/a>/', '<a href="{{ route(\'admin.categories\') }}">Categories</a>', \$content);
        \$content = preg_replace('/<a href=".*?">Users<\/a>/', '<a href="{{ route(\'admin.users\') }}">Users</a>', \$content);
        file_put_contents(\$view, \$content);
    }
}

echo "Admin links logic fixed.";
