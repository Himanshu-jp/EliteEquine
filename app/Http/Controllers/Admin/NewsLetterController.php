<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\NewsletterService;

class NewsLetterController extends Controller
{
    protected $newsletterService;
    public function __construct(NewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }

    /** 
     * newsletter
    */
    public function index(Request $request)
    {
        $filters = $request->only(['search']);
        
        $newsletters = $this->newsletterService->newsletterList($filters);
        return view('admin.newsletters.index', compact('newsletters'));
    }

    public function destroy($id)
    {
        $this->newsletterService->delete($id);
        return redirect()->route('newsletters.index')->with('success', 'Newsletter soft-deleted.');
    }

    // Restore a deleted category
    public function restore($id)
    {
        $this->newsletterService->restore($id);
        return redirect()->route('newsletters.index')->with('success', 'Newsletter restored successfully!');
    }
}
