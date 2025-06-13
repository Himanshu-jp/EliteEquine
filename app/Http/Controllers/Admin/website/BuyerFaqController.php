<?php

namespace App\Http\Controllers\Admin\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuyerFaq;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\website\FaqRequest;
use Illuminate\View\View;
use App\Services\Admin\website\FaqService;

class BuyerFaqController extends Controller
{
    protected $FaqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BuyerFaq::query();

        if ($request->filled('question')) {
            $query->where('question', 'like', '%' . $request->question . '%');
        }

        $faqs = $query->latest()->paginate(10);
        
        return view('admin.website_manage.home.buyer_browser.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.website_manage.home.buyer_browser.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        $this->faqService->store($request->validated());

        return redirect()
            ->route('buyer-faqs.index') // Corrected route name
            ->with('success', 'FAQ created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BuyerFaq $buyerFaq): View
    {
        return view('admin.website_manage.home.buyer_browser.faqs.show', compact('buyerFaq'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BuyerFaq $buyerFaq): View
    {
        return view('admin.website_manage.home.buyer_browser.faqs.edit', compact('buyerFaq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request, BuyerFaq $buyerFaq): RedirectResponse
    {
        $this->faqService->update($buyerFaq, $request->validated());

        return redirect()
            ->route('buyer-faqs.index')
            ->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BuyerFaq $buyerFaq): RedirectResponse
    {
        $this->faqService->delete($buyerFaq);

        return redirect()
            ->route('buyer-faqs.index')
            ->with('success', 'FAQ deleted successfully.');
    }

    // Restore a deleted category
    public function restore($id)
    {
        $this->faqService->restore($id);
        return redirect()->route('buyer-faqs.index')->with('success', 'FAQ restored successfully!');
    }
}
