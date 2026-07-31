<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminBlogController extends Controller {
    public function index() {
        $blogs = Blog::with('user', 'categories')->latest()->get();
        return view('admin.blogs', compact('blogs'));
    }
    public function approve($id) {
        $blog = Blog::findOrFail($id);
        $blog->update(['status' => 'approved']);
        return back()->with('success', 'Blog approved successfully.');
    }
    public function reject($id) {
        $blog = Blog::findOrFail($id);
        $blog->update(['status' => 'rejected']);
        return back()->with('success', 'Blog rejected.');
    }
    public function create() {
        $categories = Category::all();
        $all_blogs = Blog::with('categories')->latest()->get();
        return view('admin.blogs-create', compact('categories', 'all_blogs'));
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
            'user_id' => Auth::guard('admin')->id() ?? 1,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(1000, 9999),
            'content' => $request->content,
            'excerpt' => Str::limit(strip_tags($request->content), 100),
            'featured_image' => !empty($gallery) ? $gallery[0] : "https://picsum.photos/seed/".rand(100,999)."/800/400",
            'gallery_images' => json_encode($gallery),
            'status' => 'approved'
        ]);
        
        $blog->categories()->sync($request->category_ids);
        
        return back()->with('success', 'Blog published successfully.');
    }

    public function edit($id) {
        $blog = Blog::findOrFail($id);
        $categories = Category::all();
        return view('admin.blogs-edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id) {
        $blog = Blog::findOrFail($id);
        
        $request->validate([
            'title' => 'required|max:250|unique:blogs,title,' . $id,
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'content' => 'required',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120'
        ]);

        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->excerpt = Str::limit(strip_tags($request->content), 100);
        $blog->status = $request->status ?? $blog->status;
        
        if ($request->hasFile('images')) {
            $gallery = [];
            foreach ($request->file('images') as $file) {
                $path = \App\Helpers\ImageHelper::uploadAndConvertToWebp($file, 'blogs/gallery');
                $gallery[] = '/storage/' . $path;
            }
            if (!empty($gallery)) {
                $blog->featured_image = $gallery[0];
                $blog->gallery_images = json_encode($gallery);
            }
        } else {
            // Handle removal of existing images if no new images are uploaded
            if ($request->has('remove_existing_images')) {
                $existingGallery = !empty($blog->gallery_images) ? json_decode($blog->gallery_images, true) : [];
                if (!is_array($existingGallery)) $existingGallery = [];
                
                $existingGallery = array_values(array_diff($existingGallery, $request->remove_existing_images));
                
                if (!empty($existingGallery)) {
                    $blog->gallery_images = json_encode($existingGallery);
                    $blog->featured_image = $existingGallery[0];
                } else {
                    $blog->gallery_images = null;
                    // If no images left and user had featured image, unset it if it was in the removed list
                    if (in_array($blog->featured_image, $request->remove_existing_images)) {
                        $blog->featured_image = null;
                    }
                }
            }
        }
        
        $blog->save();
        $blog->categories()->sync($request->category_ids);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy($id) {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return back()->with('success', 'Blog deleted successfully.');
    }

    public function uploadImage(Request $request) {
        if ($request->hasFile('file')) {
            $path = \App\Helpers\ImageHelper::uploadAndConvertToWebp($request->file('file'), 'blogs/content');
            return response()->json(['location' => asset('storage/' . $path)]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}