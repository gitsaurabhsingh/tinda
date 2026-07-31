<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller {
    public function index() {
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }
    public function store(Request $request) {
        $request->validate(['name' => 'required', 'image' => 'nullable|image']);
        $imagePath = null;
        if($request->hasFile('image')) {
            $path = \App\Helpers\ImageHelper::uploadAndConvertToWebp($request->file('image'), 'categories');
            $imagePath = '/storage/' . $path;
        }
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath
        ]);
        return back()->with('success', 'Category created with image.');
    }
    public function edit($id) {
        $category = Category::findOrFail($id);
        return view('admin.categories-edit', compact('category'));
    }

    public function update(Request $request, $id) {
        $category = Category::findOrFail($id);
        $request->validate(['name' => 'required', 'image' => 'nullable|image']);
        
        if($request->hasFile('image')) {
            $path = \App\Helpers\ImageHelper::uploadAndConvertToWebp($request->file('image'), 'categories');
            $category->image = '/storage/' . $path;
        }
        
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->save();
        
        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }

    public function destroy($id) {
        Category::findOrFail($id)->delete();
        return back()->with('success', 'Category deleted.');
    }
}