<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Page;

class SitemapController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', 'approved')->orderBy('updated_at', 'desc')->get();
        $categories = Category::orderBy('updated_at', 'desc')->get();
        $pages = Page::where('status', 'published')->orderBy('updated_at', 'desc')->get();

        return response()->view('sitemap', [
            'blogs' => $blogs,
            'categories' => $categories,
            'pages' => $pages,
        ])->header('Content-Type', 'text/xml');
    }
}
