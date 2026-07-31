<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::all();
        
        $baseQuery = Blog::with(['categories', 'user'])->where('status', 'approved');
        
        // 1. Latest Blogs (Left column)
        $latestBlogs = (clone $baseQuery)->latest()->take(10)->get();
        
        // 2. Popular Blogs (Left column tab)
        $popularBlogs = (clone $baseQuery)->orderBy('views', 'desc')->take(10)->get();
        
        // 3. Main News (Center column)
        $mainNews = (clone $baseQuery)->latest()->first();
        
        // 4. Trending Blogs (Right column)
        $trendingBlogs = (clone $baseQuery)->orderBy('views', 'desc')->take(10)->get();
        
        // 5. Top Authors
        $topAuthors = \App\Models\User::withCount(['blogs' => function($query) {
            $query->where('status', 'approved');
        }])->orderBy('blogs_count', 'desc')->take(4)->get();
        
        // 6. Featured Showcase
        $featuredBlogs = (clone $baseQuery)->whereNotNull('featured_image')->latest()->take(6)->get();
        if ($featuredBlogs->count() < 3) {
            $featuredBlogs = clone $latestBlogs;
        }
        // 7. Paginated More Articles
        $paginatedBlogs = (clone $baseQuery)->latest()->paginate(6)->fragment('more-articles');
        
        return view('welcome', compact('categories', 'latestBlogs', 'popularBlogs', 'mainNews', 'trendingBlogs', 'topAuthors', 'featuredBlogs', 'paginatedBlogs'));
    }

    public function categories()
    {
        $categories = \App\Models\Category::all();
        return view("pages.categories", compact("categories"));
    }
}