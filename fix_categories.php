<?php
$dir = __DIR__;

// 1. Update web.php for /categories frontend route
$routesFile = $dir . '/routes/web.php';
$routesHtml = file_get_contents($routesFile);
if (!str_contains($routesHtml, "Route::get('/categories', [App\Http\Controllers\HomeController::class, 'categories'])")) {
    // Add public categories route
    $routesHtml = str_replace(
        "Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blog.category');",
        "Route::get('/categories', [\App\Http\Controllers\HomeController::class, 'categories'])->name('public.categories');\nRoute::get('/category/{slug}', [BlogController::class, 'category'])->name('blog.category');",
        $routesHtml
    );
    file_put_contents($routesFile, $routesHtml);
}

// 2. Add categories method to HomeController
$homeController = $dir . '/app/Http/Controllers/HomeController.php';
$homeCode = file_get_contents($homeController);
if (!str_contains($homeCode, 'public function categories()')) {
    $homeCode = str_replace(
        '}',
        '    public function categories() {
        $categories = \App\Models\Category::all();
        return view("pages.categories", compact("categories"));
    }
}',
        $homeCode
    );
    file_put_contents($homeController, $homeCode);
}

// 3. Create pages.categories view
$catViewPath = $dir . '/resources/views/pages/categories.blade.php';
if (!file_exists($dir . '/resources/views/pages')) {
    mkdir($dir . '/resources/views/pages', 0777, true);
}

$catViewHtml = <<<HTML
@extends('layouts.app')
@section('title', 'All Categories')
@section('content')
<div class="container py-5 mt-4" style="min-height: 60vh;">
    <h2 class="fw-bold mb-5 text-center">Browse by Category</h2>
    <div class="row g-4">
        @foreach(\$categories as \$category)
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('blog.category', \$category->slug) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4 category-card" style="transition: 0.3s; background: #fff;">
                    @if(\$category->image)
                        <img src="{{ \$category->image }}" alt="{{ \$category->name }}" class="img-fluid rounded mb-3 mx-auto" style="height: 80px; width: 80px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="height: 80px; width: 80px; font-size: 2rem;">
                            {{ substr(\$category->name, 0, 1) }}
                        </div>
                    @endif
                    <h5 class="fw-bold text-dark m-0">{{ \$category->name }}</h5>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
<style>
.category-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>
@endsection
HTML;
file_put_contents($catViewPath, $catViewHtml);

// 4. Update Navbar links
$appLayout = $dir . '/resources/views/layouts/app.blade.php';
$appHtml = file_get_contents($appLayout);
$appHtml = str_replace(
    '<li class="nav-item"><a class="nav-link fw-medium" href="#">Categories</a></li>',
    '<li class="nav-item"><a class="nav-link fw-medium" href="{{ route(\'public.categories\') }}">Categories</a></li>',
    $appHtml
);
file_put_contents($appLayout, $appHtml);

// 5. Update welcome.blade.php to make category badge clickable
$welcomeView = $dir . '/resources/views/welcome.blade.php';
$welcomeHtml = file_get_contents($welcomeView);
$welcomeHtml = str_replace(
    '<span class="badge bg-primary mb-2 rounded-pill">{{ $blog->category->name }}</span>',
    '<a href="{{ route(\'blog.category\', $blog->category->slug) }}" class="text-decoration-none"><span class="badge bg-primary mb-2 rounded-pill">{{ $blog->category->name }}</span></a>',
    $welcomeHtml
);
file_put_contents($welcomeView, $welcomeHtml);

// 6. Implement BlogController@category (which was stubbed in routes but never implemented)
$blogController = $dir . '/app/Http/Controllers/BlogController.php';
$blogCode = file_get_contents($blogController);
if (!str_contains($blogCode, 'public function category(')) {
    $blogCode = str_replace(
        '}',
        '    public function category($slug) {
        $category = \App\Models\Category::where("slug", $slug)->firstOrFail();
        $blogs = \App\Models\Blog::with("category")->where("category_id", $category->id)->where("status", "approved")->latest()->get();
        return view("welcome", compact("blogs", "category")); // Reusing welcome view or simple listing
    }
}',
        $blogCode
    );
    file_put_contents($blogController, $blogCode);
}


// Fix welcome.blade.php to dynamically show "Latest Blogs" vs "Category: X"
$welcomeHtml = file_get_contents($welcomeView);
$welcomeHtml = str_replace(
    '<h2 class="fw-bold mb-4">Latest Blogs</h2>',
    '<h2 class="fw-bold mb-4">{{ isset($category) ? "Blogs in: " . $category->name : "Latest Blogs" }}</h2>',
    $welcomeHtml
);
file_put_contents($welcomeView, $welcomeHtml);

echo "Categories links fixed.";
