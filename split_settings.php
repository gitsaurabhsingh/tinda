<?php
$dir = __DIR__;
$adminDir = $dir . '/resources/views/admin/';

// 1. Update Layout Sidebar
$layoutFile = $adminDir . 'layout.blade.php';
$layoutHtml = file_get_contents($layoutFile);
$layoutHtml = str_replace(
    '<a href="{{ route(\'admin.settings\') }}" class="{{ request()->routeIs(\'admin.settings\') ? \'active\' : \'\' }}">Hero & Footer Settings</a>',
    '<a href="{{ route(\'admin.settings.hero\') }}" class="{{ request()->routeIs(\'admin.settings.hero\') ? \'active\' : \'\' }}">Hero Settings</a>
            <a href="{{ route(\'admin.settings.footer\') }}" class="{{ request()->routeIs(\'admin.settings.footer\') ? \'active\' : \'\' }}">Footer Settings</a>',
    $layoutHtml
);
file_put_contents($layoutFile, $layoutHtml);


// 2. Update Routes
$routesFile = $dir . '/routes/web.php';
$routesHtml = file_get_contents($routesFile);
$routesHtml = str_replace(
    "Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings');",
    "Route::get('/settings/hero', [\App\Http\Controllers\Admin\SettingController::class, 'hero'])->name('settings.hero');\n    Route::get('/settings/footer', [\App\Http\Controllers\Admin\SettingController::class, 'footer'])->name('settings.footer');",
    $routesHtml
);
file_put_contents($routesFile, $routesHtml);


// 3. Update SettingController
$settingController = $dir . '/app/Http/Controllers/Admin/SettingController.php';
$settingCode = <<<PHP
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function hero()
    {
        \$settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings-hero', compact('settings'));
    }
    
    public function footer()
    {
        \$settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings-footer', compact('settings'));
    }

    public function update(Request \$request)
    {
        \$data = \$request->except('_token', '_method', 'hero_image_file');
        
        // Handle file upload for hero image
        if (\$request->hasFile('hero_image_file')) {
            \$path = \$request->file('hero_image_file')->store('settings', 'public');
            \$data['hero_image'] = '/storage/' . \$path;
        }

        foreach (\$data as \$key => \$value) {
            Setting::updateOrCreate(['key' => \$key], ['value' => \$value]);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
PHP;
file_put_contents($settingController, $settingCode);


// 4. Create Hero Settings View
$heroHtml = <<<HTML
@extends('admin.layout')
@section('title', 'Hero Settings')
@section('content')
<h2 class="fw-bold mb-4">Hero Banner Settings</h2>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">Site Name (Navbar)</label>
                <input type="text" name="site_name" class="form-control" value="{{ \$settings['site_name'] ?? '' }}">
            </div>
            
            <hr class="my-4">
            
            <div class="mb-3">
                <label class="form-label fw-bold">Hero Background Image</label>
                @if(!empty(\$settings['hero_image']))
                    <div class="mb-2">
                        <img src="{{ \$settings['hero_image'] }}" alt="Current Hero" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                @endif
                <input type="file" name="hero_image_file" class="form-control" accept="image/*">
                <small class="text-muted">Select an image from your folder to change the homepage banner.</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Hero Banner Title</label>
                <input type="text" name="hero_title" class="form-control" value="{{ \$settings['hero_title'] ?? '' }}">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Hero Banner Subtitle</label>
                <input type="text" name="hero_subtitle" class="form-control" value="{{ \$settings['hero_subtitle'] ?? '' }}">
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg mt-4 px-5 fw-bold rounded-pill">Save Hero Settings</button>
        </form>
    </div>
</div>
@endsection
HTML;
file_put_contents($adminDir . 'settings-hero.blade.php', $heroHtml);


// 5. Create Footer Settings View
$footerHtml = <<<HTML
@extends('admin.layout')
@section('title', 'Footer Settings')
@section('content')
<h2 class="fw-bold mb-4">Footer & Social Settings</h2>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="form-label fw-bold">Footer About Text</label>
                <textarea name="footer_text" class="form-control" rows="4">{{ \$settings['footer_text'] ?? '' }}</textarea>
            </div>
            
            <h5 class="fw-bold text-primary mb-3">Social Links</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Facebook Link</label>
                    <input type="url" name="facebook" class="form-control" value="{{ \$settings['facebook'] ?? '' }}" placeholder="https://facebook.com/...">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Twitter Link</label>
                    <input type="url" name="twitter" class="form-control" value="{{ \$settings['twitter'] ?? '' }}" placeholder="https://twitter.com/...">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Instagram Link</label>
                    <input type="url" name="instagram" class="form-control" value="{{ \$settings['instagram'] ?? '' }}" placeholder="https://instagram.com/...">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg mt-4 px-5 fw-bold rounded-pill">Save Footer Settings</button>
        </form>
    </div>
</div>
@endsection
HTML;
file_put_contents($adminDir . 'settings-footer.blade.php', $footerHtml);


// Remove old settings view if exists
if(file_exists($adminDir . 'settings.blade.php')) {
    unlink($adminDir . 'settings.blade.php');
}

echo "Settings split and image upload enabled.";
