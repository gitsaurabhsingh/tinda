<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories', [\App\Http\Controllers\HomeController::class, 'categories'])->name('public.categories');
Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/api/search', [BlogController::class, 'search'])->name('api.search');

Route::post('/subscribe', [\App\Http\Controllers\SubscriberController::class, 'store'])->name('subscribe');

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// OTP Authentication Routes
Route::post('/auth/login/send-otp', [\App\Http\Controllers\Auth\OtpAuthController::class, 'sendLoginOtp'])->name('otp.login.send');
Route::post('/auth/register/send-otp', [\App\Http\Controllers\Auth\OtpAuthController::class, 'sendRegisterOtp'])->name('otp.register.send');
Route::post('/auth/verify-otp', [\App\Http\Controllers\Auth\OtpAuthController::class, 'verifyOtp'])->name('otp.verify');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $blogs = auth()->user()->blogs()->latest()->get();
        return view('dashboard', compact('blogs'));
    })->name('dashboard');
    Route::get('/dashboard/blogs/create', [\App\Http\Controllers\UserBlogController::class, 'create'])->name('user.blogs.create');
    Route::post('/dashboard/blogs/store', [\App\Http\Controllers\UserBlogController::class, 'store'])->name('user.blogs.store');
    Route::get('/dashboard/blogs/{id}/edit', [\App\Http\Controllers\UserBlogController::class, 'edit'])->name('user.blogs.edit');
    Route::put('/dashboard/blogs/{id}', [\App\Http\Controllers\UserBlogController::class, 'update'])->name('user.blogs.update');
    Route::delete('/dashboard/blogs/{id}', [\App\Http\Controllers\UserBlogController::class, 'destroy'])->name('user.blogs.destroy');

    // Profile routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('guest')->group(function () {
    Route::get('/admin-login', [\App\Http\Controllers\Auth\AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('/admin-login', [\App\Http\Controllers\Auth\AdminLoginController::class, 'store'])->name('admin.login.post');
});

Route::post('/admin-logout', [\App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');

Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    Route::get('/settings/header', [\App\Http\Controllers\Admin\SettingController::class, 'header'])->name('settings.header');
    
    Route::get('/settings/cta', [App\Http\Controllers\Admin\SettingController::class, 'cta'])->name('settings.cta');
    Route::get('/settings/hero', [\App\Http\Controllers\Admin\SettingController::class, 'hero'])->name('settings.hero');
    Route::get('/settings/footer', [\App\Http\Controllers\Admin\SettingController::class, 'footer'])->name('settings.footer');
    Route::get('/settings', function() { return redirect()->route('admin.settings.hero'); });
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    
    Route::get('/profile', [\App\Http\Controllers\Admin\AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\Admin\AdminController::class, 'updateProfile'])->name('profile.update');
    
    // Redirect old pending route to index
    Route::redirect('/blogs/pending', '/admin/blogs');
    
    Route::post('/blogs/upload-image', [\App\Http\Controllers\Admin\AdminBlogController::class, 'uploadImage'])->name('blogs.upload-image');
    Route::get('/blogs', [\App\Http\Controllers\Admin\AdminBlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [\App\Http\Controllers\Admin\AdminBlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [\App\Http\Controllers\Admin\AdminBlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{id}/edit', [\App\Http\Controllers\Admin\AdminBlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{id}', [\App\Http\Controllers\Admin\AdminBlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{id}', [\App\Http\Controllers\Admin\AdminBlogController::class, 'destroy'])->name('blogs.destroy');
    Route::post('/blogs/{id}/approve', [\App\Http\Controllers\Admin\AdminBlogController::class, 'approve'])->name('blogs.approve');
    Route::post('/blogs/{id}/reject', [\App\Http\Controllers\Admin\AdminBlogController::class, 'reject'])->name('blogs.reject');
    
    Route::get('/categories', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    
    Route::get('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('users.destroy');
    
    Route::get('/subscribers', [\App\Http\Controllers\Admin\AdminSubscriberController::class, 'index'])->name('subscribers');
    Route::delete('/subscribers/{id}', [\App\Http\Controllers\Admin\AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');
    
    Route::resource('/pages', \App\Http\Controllers\Admin\AdminPageController::class);
    
    Route::get('/contacts', [\App\Http\Controllers\Admin\AdminContactMessageController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/unread-count', function() {
        return response()->json(['count' => \App\Models\ContactMessage::where('is_read', false)->count()]);
    })->name('contacts.unread');
    Route::post('/contacts/{id}/read', [\App\Http\Controllers\Admin\AdminContactMessageController::class, 'markAsRead'])->name('contacts.read');
    Route::delete('/contacts/{id}', [\App\Http\Controllers\Admin\AdminContactMessageController::class, 'destroy'])->name('contacts.destroy');
});

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Dynamic Pages and Blogs Catch-all
Route::post('/contact/submit', [\App\Http\Controllers\PageController::class, 'submitContact'])->name('contact.submit');
Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('page.show');

// Helpful routes for Live Deployment
Route::get('/create-storage-link', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return 'Storage link created successfully! Your images should now be visible.';
    } catch (\Exception $e) {
        return 'Error creating storage link: ' . $e->getMessage();
    }
});

Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Application cache cleared successfully!';
});