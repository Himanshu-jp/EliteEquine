<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\Admin\SubCategoryService;

class SubCategoryController extends Controller
{
    protected SubCategoryService $service;

    public function __construct(SubCategoryService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {   
        $categories = Category::orderBy('name')->get();
        // $subCategories = SubCategory::with('category')->orderBy('id', 'desc')->paginate(10);
        $query = SubCategory::with('category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $subCategories = $query->paginate(10);
        return view('admin.subcategories.index', compact('subCategories', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(SubCategoryRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('sub-categories.index')->with('success', 'Subcategory created.');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.subcategories.edit', compact('subCategory', 'categories'));
    }

    public function update(SubCategoryRequest $request, SubCategory $subCategory)
    {
        $this->service->update($subCategory, $request->validated());
        return redirect()->route('sub-categories.index')->with('success', 'Subcategory updated.');
    }

    public function destroy(SubCategory $subCategory)
    {
        $this->service->delete($subCategory);
        return redirect()->route('sub-categories.index')->with('success', 'Subcategory deleted.');
    }
}
