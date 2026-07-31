<?php
// 1. Update routes/web.php
$routes = file_get_contents('routes/web.php');
if (strpos($routes, "Route::get('/settings/cta'") === false) {
    $routeToAdd = "\n    Route::get('/settings/cta', [App\Http\Controllers\Admin\SettingController::class, 'cta'])->name('admin.settings.cta');";
    $routes = str_replace("Route::get('/settings/hero'", $routeToAdd . "\n    Route::get('/settings/hero'", $routes);
    file_put_contents('routes/web.php', $routes);
}

// 2. Update SettingController
$controller = file_get_contents('app/Http/Controllers/Admin/SettingController.php');
if (strpos($controller, 'public function cta()') === false) {
    $methodToAdd = <<<'EOT'
    
    public function cta()
    {
        return view('admin.settings.cta');
    }
EOT;
    $controller = str_replace('public function header()', $methodToAdd . "\n\n    public function header()", $controller);
    file_put_contents('app/Http/Controllers/Admin/SettingController.php', $controller);
}

// 3. Create the view
$viewContent = <<<'EOT'
@extends('admin.layout')
@section('title', 'CTA Settings')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>CTA Settings</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">CTA Badge Text</label>
                <input type="text" name="settings[cta_badge]" class="form-control" value="{{ App\Models\Setting::get('cta_badge', 'EXCLUSIVE REAL ESTATE DEALS') }}">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">CTA Title</label>
                <input type="text" name="settings[cta_title]" class="form-control" value="{{ App\Models\Setting::get('cta_title', 'Looking for the Best Property Investment?') }}">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">CTA Subtitle</label>
                <textarea name="settings[cta_subtitle]" class="form-control" rows="3">{{ App\Models\Setting::get('cta_subtitle', 'Get a free consultation with our experts and discover premium residential flats, townships, and commercial spaces with assured returns.') }}</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">WhatsApp Number (with country code)</label>
                    <input type="text" name="settings[cta_whatsapp]" class="form-control" value="{{ App\Models\Setting::get('cta_whatsapp', '919876543210') }}">
                    <div class="form-text">Example: 919876543210 (No + sign)</div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">WhatsApp Button Text</label>
                    <input type="text" name="settings[cta_wa_text]" class="form-control" value="{{ App\Models\Setting::get('cta_wa_text', 'Chat on WhatsApp') }}">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Secondary Button Text</label>
                    <input type="text" name="settings[cta_btn_text]" class="form-control" value="{{ App\Models\Setting::get('cta_btn_text', 'Request a Call Back') }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Secondary Button Link</label>
                    <input type="text" name="settings[cta_btn_link]" class="form-control" value="{{ App\Models\Setting::get('cta_btn_link', '#') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3"><i class="fa-solid fa-save me-2"></i>Save Settings</button>
        </form>
    </div>
</div>
@endsection
EOT;

if (!is_dir('resources/views/admin/settings')) {
    mkdir('resources/views/admin/settings', 0755, true);
}
file_put_contents('resources/views/admin/settings/cta.blade.php', $viewContent);

// 4. Update Admin sidebar layout
$layout = file_get_contents('resources/views/admin/layout.blade.php');
if (strpos($layout, 'admin.settings.cta') === false) {
    $navItem = <<<'EOT'
                    <a class="nav-link {{ request()->routeIs('admin.settings.cta') ? 'active' : '' }}" href="{{ route('admin.settings.cta') }}">
                        <i class="fa-solid fa-bullhorn fa-fw"></i> CTA Settings
                    </a>
EOT;
    $layout = str_replace('<!-- Add more settings here if needed -->', $navItem . "\n                    <!-- Add more settings here if needed -->", $layout);
    
    // If the comment doesn't exist, we fallback to just replacing before 'Logout' or similar
    if (strpos($layout, '<!-- Add more settings here if needed -->') === false) {
        $layout = str_replace('<a class="nav-link text-danger"', $navItem . "\n                    <a class=\"nav-link text-danger\"", $layout);
    }
    
    file_put_contents('resources/views/admin/layout.blade.php', $layout);
}

// 5. Update welcome.blade.php to use the dynamic fields
$welcome = file_get_contents('resources/views/welcome.blade.php');
$welcome = str_replace('EXCLUSIVE REAL ESTATE DEALS', "{{ App\Models\Setting::get('cta_badge', 'EXCLUSIVE REAL ESTATE DEALS') }}", $welcome);
$welcome = str_replace('Looking for the Best Property Investment?', "{!! App\Models\Setting::get('cta_title', 'Looking for the Best Property Investment?') !!}", $welcome);
$welcome = str_replace('Get a free consultation with our experts and discover premium residential flats, townships, and commercial spaces with assured returns.', "{!! App\Models\Setting::get('cta_subtitle', 'Get a free consultation with our experts and discover premium residential flats, townships, and commercial spaces with assured returns.') !!}", $welcome);
$welcome = str_replace('https://wa.me/919876543210', "https://wa.me/{{ App\Models\Setting::get('cta_whatsapp', '919876543210') }}", $welcome);
$welcome = str_replace('Chat on WhatsApp', "{{ App\Models\Setting::get('cta_wa_text', 'Chat on WhatsApp') }}", $welcome);
$welcome = str_replace('Request a Call Back', "{{ App\Models\Setting::get('cta_btn_text', 'Request a Call Back') }}", $welcome);
$welcome = preg_replace('/href="[^"]*"(\s+class="btn w-100 py-3 fw-bold text-dark d-flex)/', 'href="{{ App\Models\Setting::get(\'cta_btn_link\', \'#\') }}"$1', $welcome);

file_put_contents('resources/views/welcome.blade.php', $welcome);

echo "Backend setup complete for Dynamic CTA.\n";
