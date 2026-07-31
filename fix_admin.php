<?php

$dir = __DIR__;

// 1. AdminController with real stats
$adminControllerFile = $dir . '/app/Http/Controllers/Admin/AdminController.php';
$adminControllerContent = <<<PHP
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use App\Models\Comment;

class AdminController extends Controller
{
    public function index()
    {
        \$stats = [
            'total_blogs' => Blog::count(),
            'pending_blogs' => Blog::where('status', 'pending')->count(),
            'total_users' => User::count(),
            'total_comments' => Comment::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}
PHP;
file_put_contents($adminControllerFile, $adminControllerContent);

// 2. SettingController
$settingControllerFile = $dir . '/app/Http/Controllers/Admin/SettingController.php';
$settingControllerContent = <<<PHP
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        \$settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request \$request)
    {
        \$data = \$request->except('_token', '_method');
        
        foreach (\$data as \$key => \$value) {
            Setting::updateOrCreate(['key' => \$key], ['value' => \$value]);
        }

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
}
PHP;
file_put_contents($settingControllerFile, $settingControllerContent);

// 3. Admin Routes
$routesFile = $dir . '/routes/web.php';
$routesHtml = file_get_contents($routesFile);
if(!str_contains($routesHtml, 'SettingController')) {
    $routesHtml = str_replace(
        "Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');", 
        "Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');\n    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings');\n    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');", 
        $routesHtml
    );
    file_put_contents($routesFile, $routesHtml);
}

// 4. Update Admin Dashboard View
$dashboardFile = $dir . '/resources/views/admin/dashboard.blade.php';
$dashboardHtml = file_get_contents($dashboardFile);
$dashboardHtml = str_replace('124', '{{ $stats["total_blogs"] }}', $dashboardHtml);
$dashboardHtml = str_replace('8', '{{ $stats["pending_blogs"] }}', $dashboardHtml);
$dashboardHtml = str_replace('56', '{{ $stats["total_users"] }}', $dashboardHtml);
$dashboardHtml = str_replace('312', '{{ $stats["total_comments"] }}', $dashboardHtml);
$dashboardHtml = str_replace('href="#"', 'href="{{ route(\'admin.settings\') }}"', $dashboardHtml); // Simplistic replace for settings link, will refine in view directly.
file_put_contents($dashboardFile, $dashboardHtml);

// Fix sidebar links properly
$dashboardHtml = file_get_contents($dashboardFile);
$dashboardHtml = preg_replace('/<a href=".*">Settings<\/a>/', '<a href="{{ route(\'admin.settings\') }}">Settings</a>', $dashboardHtml);
file_put_contents($dashboardFile, $dashboardHtml);


// 5. Admin Settings View
$settingsViewFile = $dir . '/resources/views/admin/settings.blade.php';
$settingsHtml = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Settings - Admin</title>
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
            <a href="#">Blogs (Pending)</a>
            <a href="#">Categories</a>
            <a href="#">Users</a>
            <a href="{{ route('admin.settings') }}" class="active">Settings</a>
            <a href="/" class="mt-5 text-warning">&larr; Back to Site</a>
        </div>
        
        <div class="flex-grow-1 p-5">
            <h2 class="fw-bold mb-4">Global Site Settings</h2>
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Site Name (Navbar)</label>
                            <input type="text" name="site_name" class="form-control" value="{{ \$settings['site_name'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Hero Banner Title</label>
                            <input type="text" name="hero_title" class="form-control" value="{{ \$settings['hero_title'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Hero Banner Subtitle</label>
                            <input type="text" name="hero_subtitle" class="form-control" value="{{ \$settings['hero_subtitle'] ?? '' }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Footer Text</label>
                            <textarea name="footer_text" class="form-control" rows="3">{{ \$settings['footer_text'] ?? '' }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4 fw-bold rounded-pill">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
file_put_contents($settingsViewFile, $settingsHtml);

echo "Admin settings logic fixed.";
