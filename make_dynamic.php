<?php
$projectDir = __DIR__;

// 1. AppServiceProvider (View Composer for settings)
$providerFile = $projectDir . '/app/Providers/AppServiceProvider.php';
$providerContent = <<<PHP
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // View Composer for Settings
        View::composer('*', function (\$view) {
            \$settings = [];
            if (Schema::hasTable('settings')) {
                \$settingsDb = Setting::all();
                foreach (\$settingsDb as \$setting) {
                    \$settings[\$setting->key] = \$setting->value;
                }
            }
            // Defaults
            if (empty(\$settings['site_name'])) \$settings['site_name'] = 'Tindablog';
            if (empty(\$settings['footer_text'])) \$settings['footer_text'] = 'Premium modern blogging platform built with Laravel 12.';
            if (empty(\$settings['hero_title'])) \$settings['hero_title'] = 'Welcome to Tindablog';
            if (empty(\$settings['hero_subtitle'])) \$settings['hero_subtitle'] = 'Discover premium articles on technology, lifestyle, and business.';
            
            \$view->with('settings', \$settings);
        });
    }
}
PHP;
file_put_contents($providerFile, $providerContent);

// 2. Database Seeder for dummy data
$seederFile = $projectDir . '/database/seeders/DatabaseSeeder.php';
$seederContent = <<<PHP
<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \$user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);

        \$cat = Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'description' => 'Tech news and guides'
        ]);

        for (\$i = 1; \$i <= 6; \$i++) {
            Blog::create([
                'user_id' => \$user->id,
                'category_id' => \$cat->id,
                'title' => "Dynamic Blog Title {\$i}",
                'slug' => "dynamic-blog-title-{\$i}",
                'content' => "<p>This is the full rich text content for blog {\$i}. It will be dynamic.</p>",
                'excerpt' => "This is a short excerpt for blog {\$i} to show on the card...",
                'featured_image' => "https://picsum.photos/seed/{\$i}0/400/250",
                'status' => 'approved'
            ]);
        }

        Setting::insert([
            ['key' => 'site_name', 'value' => 'Tindablog Dynamic'],
            ['key' => 'footer_text', 'value' => 'This footer is managed dynamically from the admin database!'],
            ['key' => 'hero_title', 'value' => 'Dynamic Hero Banner'],
            ['key' => 'hero_subtitle', 'value' => 'This banner text comes from the DB settings.']
        ]);
    }
}
PHP;
file_put_contents($seederFile, $seederContent);

// 3. Controllers
$homeControllerContent = <<<PHP
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        \$blogs = Blog::with('category')->where('status', 'approved')->latest()->take(6)->get();
        return view('welcome', compact('blogs'));
    }
}
PHP;
file_put_contents($projectDir . '/app/Http/Controllers/HomeController.php', $homeControllerContent);

$blogControllerContent = <<<PHP
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function show(\$slug)
    {
        \$blog = Blog::with(['category', 'user'])->where('slug', \$slug)->where('status', 'approved')->firstOrFail();
        
        // Increase views
        \$blog->increment('views');

        return view('pages.blog-detail', compact('blog'));
    }
}
PHP;
file_put_contents($projectDir . '/app/Http/Controllers/BlogController.php', $blogControllerContent);

// 4. Update App Layout to use settings
$layoutFile = $projectDir . '/resources/views/layouts/app.blade.php';
$layoutHtml = file_get_contents($layoutFile);
$layoutHtml = str_replace('Tindablog', '{{ $settings["site_name"] ?? "Tindablog" }}', $layoutHtml);
$layoutHtml = str_replace('Premium modern blogging platform built with Laravel 12.', '{{ $settings["footer_text"] ?? "" }}', $layoutHtml);
file_put_contents($layoutFile, $layoutHtml);

// 5. Update Welcome View to use dynamic DB blogs and hero settings
$welcomeFile = $projectDir . '/resources/views/welcome.blade.php';
$welcomeHtml = <<<HTML
@extends('layouts.app')

@section('title', \$settings['site_name'] . ' - Home')

@section('content')
<section class="hero text-center text-white">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">{{ \$settings['hero_title'] }}</h1>
        <p class="lead mb-5 opacity-75">{{ \$settings['hero_subtitle'] }}</p>
        <a href="#latest" class="btn btn-accent btn-lg fw-semibold shadow-sm">Start Reading</a>
    </div>
</section>

<div id="latest" class="container py-5">
    <h2 class="fw-bold mb-4">Latest Blogs</h2>
    <div class="row g-4">
        @foreach(\$blogs as \$blog)
        <div class="col-md-4">
            <div class="card blog-card h-100">
                <img src="{{ \$blog->featured_image }}" class="card-img-top" alt="{{ \$blog->title }}" style="border-radius: 20px 20px 0 0; object-fit: cover; height: 200px;">
                <div class="card-body">
                    <span class="badge bg-primary mb-2 rounded-pill">{{ \$blog->category->name }}</span>
                    <h5 class="card-title fw-bold">{{ \$blog->title }}</h5>
                    <p class="card-text text-muted">{{ Str::limit(\$blog->excerpt, 100) }}</p>
                    <a href="{{ route('blog.show', \$blog->slug) }}" class="text-primary text-decoration-none fw-semibold">Read More &rarr;</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
HTML;
file_put_contents($welcomeFile, $welcomeHtml);

// 6. Create Blog Detail View
if(!is_dir($projectDir.'/resources/views/pages')) mkdir($projectDir.'/resources/views/pages');
$detailFile = $projectDir . '/resources/views/pages/blog-detail.blade.php';
$detailHtml = <<<HTML
@extends('layouts.app')

@section('title', \$blog->seo_title ?? \$blog->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <span class="badge bg-primary mb-3">{{ \$blog->category->name }}</span>
            <h1 class="fw-bold mb-4">{{ \$blog->title }}</h1>
            
            <div class="d-flex align-items-center mb-4 text-muted">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(\$blog->user->name) }}" class="rounded-circle me-2" width="40" height="40">
                <span>By <strong>{{ \$blog->user->name }}</strong> &nbsp;|&nbsp; {{ \$blog->created_at->format('M d, Y') }} &nbsp;|&nbsp; {{ \$blog->views }} Views</span>
            </div>

            <img src="{{ \$blog->featured_image }}" class="img-fluid rounded-4 w-100 mb-5 shadow-sm" alt="{{ \$blog->title }}">

            <div class="blog-content" style="font-size: 1.1rem; line-height: 1.8;">
                {!! \$blog->content !!}
            </div>
        </div>
    </div>
</div>
@endsection
HTML;
file_put_contents($detailFile, $detailHtml);

echo "Dynamic setup complete.";
