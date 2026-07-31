<?php
$routesFile = __DIR__ . '/routes/web.php';
$routesContent = file_get_contents($routesFile);

if (!str_contains($routesContent, '/admin')) {
    $adminRoute = <<<PHP

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
});
PHP;
    file_put_contents($routesFile, $adminRoute, FILE_APPEND);
}

$adminControllerFile = __DIR__ . '/app/Http/Controllers/Admin/AdminController.php';
$adminControllerContent = <<<PHP
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
}
PHP;
file_put_contents($adminControllerFile, $adminControllerContent);

$viewsDir = __DIR__ . '/resources/views/admin/';
if (!is_dir($viewsDir)) mkdir($viewsDir, 0777, true);

$adminDashboardContent = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tindablog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; color: #1E293B; }
        .sidebar { background: #0F172A; min-height: 100vh; color: white; padding-top: 20px; }
        .sidebar a { color: #cbd5e1; text-decoration: none; padding: 12px 20px; display: block; transition: 0.3s; }
        .sidebar a:hover { background: #1E293B; color: white; }
        .sidebar .active { background: #2563EB; color: white; }
        .stat-card { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: none; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar" style="width: 250px;">
            <h4 class="text-center fw-bold mb-4">Tindablog Admin</h4>
            <a href="/admin" class="active">Dashboard</a>
            <a href="#">Blogs (Pending)</a>
            <a href="#">Categories</a>
            <a href="#">Users</a>
            <a href="#">Settings</a>
            <a href="/" class="mt-5 text-warning">&larr; Back to Site</a>
        </div>
        
        <div class="flex-grow-1 p-5">
            <h2 class="fw-bold mb-4">Dashboard Overview</h2>
            
            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="stat-card">
                        <h6 class="text-muted">Total Blogs</h6>
                        <h3 class="fw-bold">124</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h6 class="text-muted">Pending Review</h6>
                        <h3 class="fw-bold text-warning">8</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h6 class="text-muted">Total Users</h6>
                        <h3 class="fw-bold text-primary">56</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h6 class="text-muted">Comments</h6>
                        <h3 class="fw-bold text-success">312</h3>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Recent Activity</h5>
                    <p class="text-muted">System is running smoothly. Analytics and detailed data tables will be populated here.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
file_put_contents($viewsDir . 'dashboard.blade.php', $adminDashboardContent);

echo "Admin panel setup completed.";
