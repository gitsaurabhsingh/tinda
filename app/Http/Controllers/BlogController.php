<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function show($slug)
    {
        $blog = Blog::with(['categories', 'user'])->where('slug', $slug)->where('status', 'approved')->firstOrFail();
        
        // Increase views
        $blog->increment('views');
        
        // Related Articles
        $relatedBlogs = Blog::with(['categories', 'user'])
            ->whereHas('categories', function($q) use ($blog) {
                $q->whereIn('categories.id', $blog->categories->pluck('id'));
            })
            ->where('id', '!=', $blog->id)
            ->where('status', 'approved')
            ->latest()
            ->take(3)
            ->get();

        return view('pages.blog-detail', compact('blog', 'relatedBlogs'));
    }

    public function category($slug)
    {
        $category = \App\Models\Category::where("slug", $slug)->firstOrFail();
        
        $baseQuery = \App\Models\Blog::with(['categories', 'user'])
            ->whereHas('categories', function($q) use ($category) {
                $q->where('categories.id', $category->id);
            })
            ->where("status", "approved");
            
        $latestBlogs = (clone $baseQuery)->latest()->take(4)->get();
        $popularBlogs = (clone $baseQuery)->orderBy('views', 'desc')->take(4)->get();
        $mainNews = (clone $baseQuery)->latest()->first();
        $paginatedBlogs = (clone $baseQuery)->latest()->paginate(12);
        $categories = \App\Models\Category::all();
        
        return view("pages.category", compact("category", "paginatedBlogs", "categories")); 
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        if (empty($query)) {
            return response()->json([]);
        }

        $blogs = Blog::where('status', 'approved')
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('short_description', 'like', "%{$query}%");
            })
            ->select('id', 'title', 'slug', 'image', 'created_at')
            ->limit(5)
            ->get()
            ->map(function ($blog) {
                // Add the correct URL for the blog post
                $blog->url = route('page.show', $blog->slug);
                $blog->image_url = $blog->image ? asset('storage/' . $blog->image) : asset('assets/images/default-blog.jpg');
                $blog->date = $blog->created_at->format('M d, Y');
                return $blog;
            });

        return response()->json($blogs);
    }
}