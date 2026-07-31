<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:published,draft',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = \App\Helpers\ImageHelper::uploadAndConvertToWebp($request->file('image'), 'pages');
        }

        Page::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(100, 999),
            'content' => $request->content,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages-edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:published,draft',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120'
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = \App\Helpers\ImageHelper::uploadAndConvertToWebp($request->file('image'), 'pages');
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return back()->with('success', 'Page deleted successfully.');
    }
}
