<?php
$dir = __DIR__;

// 1. Update routes/web.php
$routesFile = $dir . '/routes/web.php';
$routesHtml = file_get_contents($routesFile);
if (!str_contains($routesHtml, 'settings.header')) {
    $routesHtml = str_replace(
        "Route::get('/settings/hero', [\App\Http\Controllers\Admin\SettingController::class, 'hero'])->name('settings.hero');",
        "Route::get('/settings/header', [\App\Http\Controllers\Admin\SettingController::class, 'header'])->name('settings.header');\n    Route::get('/settings/hero', [\App\Http\Controllers\Admin\SettingController::class, 'hero'])->name('settings.hero');",
        $routesHtml
    );
    file_put_contents($routesFile, $routesHtml);
}

// 2. Update SettingController.php
$settingController = $dir . '/app/Http/Controllers/Admin/SettingController.php';
$settingCode = file_get_contents($settingController);
if (!str_contains($settingCode, 'public function header(')) {
    $settingCode = str_replace(
        "public function hero()",
        "public function header()\n    {\n        \$settings = Setting::pluck('value', 'key')->toArray();\n        return view('admin.settings-header', compact('settings'));\n    }\n\n    public function hero()",
        $settingCode
    );
    
    // Add header_logo_file to except
    $settingCode = str_replace(
        "\$data = \$request->except('_token', '_method', 'hero_image_file');",
        "\$data = \$request->except('_token', '_method', 'hero_image_file', 'header_logo_file');",
        $settingCode
    );

    // Handle header_logo_file upload
    $settingCode = str_replace(
        "if (\$request->hasFile('hero_image_file')) {",
        "if (\$request->hasFile('header_logo_file')) {\n            \$path = \$request->file('header_logo_file')->store('settings', 'public');\n            \$data['site_logo'] = '/storage/' . \$path;\n        }\n\n        if (\$request->hasFile('hero_image_file')) {",
        $settingCode
    );
    file_put_contents($settingController, $settingCode);
}

// 3. Create settings-header.blade.php
$headerView = $dir . '/resources/views/admin/settings-header.blade.php';
$headerViewHtml = <<<HTML
@extends('admin.layout')
@section('title', 'Header Settings')
@section('content')
<h2 class="fw-bold mb-4 text-dark">Header & Branding Settings</h2>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="form-label fw-bold">Site Name (Text Logo)</label>
                <input type="text" name="site_name" class="form-control" value="{{ \$settings['site_name'] ?? 'Tindablog' }}">
                <small class="text-muted">This will be displayed if no logo image is uploaded.</small>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Site Logo Image</label>
                @if(isset(\$settings['site_logo']) && !empty(\$settings['site_logo']))
                    <div class="mb-3">
                        <img src="{{ \$settings['site_logo'] }}" alt="Current Logo" style="max-height: 60px; background: #f8fafc; padding: 10px; border-radius: 10px;">
                    </div>
                @endif
                <input type="file" name="header_logo_file" class="form-control" accept="image/*">
                <small class="text-muted">Upload a transparent PNG for best results. This will replace the Site Name text.</small>
            </div>
            
            <hr class="my-4">
            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">Save Header Settings</button>
        </form>
    </div>
</div>
@endsection
HTML;
file_put_contents($headerView, $headerViewHtml);

// 4. Update admin/layout.blade.php Sidebar
$layoutBlade = $dir . '/resources/views/admin/layout.blade.php';
$layoutHtml = file_get_contents($layoutBlade);
if (!str_contains($layoutHtml, 'settings.header')) {
    $layoutHtml = str_replace(
        '<div class="mt-4 mb-2 ps-3 text-uppercase"',
        '<a href="{{ route(\'admin.settings.header\') }}" class="nav-link {{ request()->routeIs(\'admin.settings.header\') ? \'active\' : \'\' }}">
                <i class="fa-solid fa-heading"></i> Header Settings
            </a>
            
            <div class="mt-4 mb-2 ps-3 text-uppercase"',
        $layoutHtml
    );
    file_put_contents($layoutBlade, $layoutHtml);
}

// 5. Update app.blade.php
$appLayout = $dir . '/resources/views/layouts/app.blade.php';
$appHtml = file_get_contents($appLayout);
if (!str_contains($appHtml, "isset(\$settings['site_logo'])")) {
    $appHtml = str_replace(
        '<a class="navbar-brand fw-bold text-primary fs-3" href="/">{{ $settings["site_name"] ?? "Tindablog" }}</a>',
        '<a class="navbar-brand fw-bold text-primary" href="/">
                @if(isset($settings["site_logo"]) && !empty($settings["site_logo"]))
                    <img src="{{ $settings["site_logo"] }}" alt="{{ $settings["site_name"] ?? "Logo" }}" style="max-height: 40px;">
                @else
                    <span class="fs-3">{{ $settings["site_name"] ?? "Tindablog" }}</span>
                @endif
            </a>',
        $appHtml
    );
    file_put_contents($appLayout, $appHtml);
}

echo "Header dynamic settings implemented.";
