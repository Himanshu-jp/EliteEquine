<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Admin\CategoryRequest;
use App\Services\Admin\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    // Inject CategoryService
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    // Display all categories
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10); 
        return view('admin.categories.index', compact('categories'));
    }

    // Show form to create category
    public function create()
    {
        return view('admin.categories.create');
    }

    // Store a new category
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $this->categoryService->store($data);
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    // Show form to edit category
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Update a category
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $this->categoryService->update($category, $data);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    // Soft delete a category
    public function destroy(Category $category)
    {
        $this->categoryService->destroy($category);
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }

    // Restore a deleted category
    public function restore(Category $category)
    {
        $this->categoryService->restore($category);
        return redirect()->route('categories.index')->with('success', 'Category restored successfully!');
    }
}
