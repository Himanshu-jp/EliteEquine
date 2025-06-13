<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CMSPageRequest;
use App\Models\CMSPage;
use App\Services\Admin\CMSPageService;

class CMSPageController extends Controller
{
    protected $pageService;

    // Constructor injection for PageService
    public function __construct(CMSPageService $pageService)
    {
        $this->pageService = $pageService;
    }

    // Display all pages in the admin dashboard
    public function index()
    {
        $pages = CMSPage::orderBy('id', 'desc')->paginate(10); 
        return view('admin.pages.index', compact('pages')); 
    }

    // Show form to create page
    public function create()
    {
        return view('admin.pages.create');
    }

    // Store a new page
    public function store(CMSPageRequest $request)
    {
        $data = $request->validated();
        $page = $this->pageService->create($data);
        return redirect()->route('cms_pages.index')->with('success', 'CMS Page created successfully');
    }

    // Show a specific page for editing
    public function edit($id)
    {
        $page = $this->pageService->find($id);
        return view('admin.pages.edit', compact('page'));
    }
    
    // Show a specific page (view page details)
    public function show($id)
    {
        $page = $this->pageService->find($id);
        return view('admin.pages.show', compact('page'));
    }

    // Update an existing page
    public function update(CMSPageRequest $request, CMSPage $cmsPage)
    {
        $data = $request->validated();
        $this->pageService->update($cmsPage, $data); // Corrected $page instead of $blog
        return redirect()->route('cms_pages.index')->with('success', 'CMS Page updated successfully');
    }

    public function delete($id)
    {
        $this->pageService->delete($id);
        return redirect()->route('cms_pages.index')->with('success', 'CMS page soft-deleted.');
    }

    // cms page image delete
    public function deleteImage($id)
    {
        $this->pageService->deleteImage($id);
        return back()->with('success', 'Image deleted successfully.');
    }

}
