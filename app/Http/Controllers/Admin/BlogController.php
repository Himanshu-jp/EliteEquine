<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BlogRequest;
use App\Services\Admin\BlogService;
use App\Models\Blog;
use App\Models\Category;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index(Request $request)
    {
        $query = Blog::with('category')->latest();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $blogs = $query->paginate(10)->appends($request->query());
        $categories = Category::orderBy('name')->get();
        // $blogs = Blog::with('category')->orderBy('id', 'desc')->paginate(10);
        return view('admin.blogs.index', compact('blogs', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(BlogRequest $request)
    {
        $data = $request->validated();
        $blog = $this->blogService->createBlog($data);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $data = $request->validated();
        $this->blogService->updateBlog($blog, $data);

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $this->blogService->delete($blog);
        return redirect()->route('blogs.index')->with('success', 'Blog soft-deleted.');
    }

    // Restore a deleted category
    public function restore($id)
    {
        $this->blogService->restore($id);
        return redirect()->route('blogs.index')->with('success', 'Blog restored successfully!');
    }
}
