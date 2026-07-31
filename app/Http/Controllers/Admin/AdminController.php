<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use App\Models\Comment;

use App\Models\Visitor;

class AdminController extends Controller
{
    public function index()
    {
        $today = now()->format('Y-m-d');
        
        $stats = [
            'total_blogs' => Blog::count(),
            'pending_blogs' => Blog::where('status', 'pending')->count(),
            'total_users' => User::count(),
            'total_comments' => Comment::count(),
            'total_visits' => Visitor::count(),
            'today_visits' => Visitor::where('visited_date', $today)->count(),
            'total_views' => Blog::sum('views'),
        ];
        
        $topBlogs = Blog::where('status', 'approved')->orderBy('views', 'desc')->take(5)->get();
        $recentVisitors = Visitor::latest()->take(10)->get();
        
        return view('admin.dashboard', compact('stats', 'topBlogs', 'recentVisitors'));
    }

    public function profile()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->guard('admin')->id(),
            'bio' => 'nullable|string',
        ]);

        $user = auth()->guard('admin')->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}