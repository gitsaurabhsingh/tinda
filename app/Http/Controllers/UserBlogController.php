<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;

class UserBlogController extends Controller {
    public function create() {
        $categories = Category::all();
        return view('user.blogs.create', compact('categories'));
    }
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:250|unique:blogs,title',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'content' => 'required',
            'images' => 'array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120'
        ]);
        
        $gallery = [];
        if($request->hasFile('images')) {
            foreach($request->file('images') as $file) {
                $path = \App\Helpers\ImageHelper::uploadAndConvertToWebp($file, 'blogs/gallery');
                $gallery[] = '/storage/' . $path;
            }
        }
        
        $blog = Blog::create([
            'user_id' => auth()->id() ?? 1,
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title) . '-' . rand(1000, 9999),
            'content' => $request->content,
            'excerpt' => \Illuminate\Support\Str::limit(strip_tags($request->content), 100),
            'featured_image' => !empty($gallery) ? $gallery[0] : "https://picsum.photos/seed/".rand(100,999)."/800/400",
            'gallery_images' => json_encode($gallery),
            'status' => 'pending'
        ]);
        
        $blog->categories()->sync($request->category_ids);
        
        return redirect()->route('dashboard')->with('success', 'Blog submitted for review.');
    }

    public function edit($id) {
        $blog = Blog::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $categories = Category::all();
        return view('user.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id) {
        $blog = Blog::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        $request->validate([
            'title' => 'required|max:250|unique:blogs,title,' . $id,
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'content' => 'required'
        ]);

        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->excerpt = \Illuminate\Support\Str::limit(strip_tags($request->content), 100);
        // Do not update images or status on simple edit, or optionally reset status to pending if needed.
        $blog->save();
        $blog->categories()->sync($request->category_ids);

        return redirect()->route('dashboard')->with('success', 'Blog updated successfully.');
    }

    public function destroy($id) {
        $blog = Blog::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $blog->delete();
        return redirect()->route('dashboard')->with('success', 'Blog deleted successfully.');
    }
}