<?php

namespace App\Http\Controllers\Admin\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuyerBrowser;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\website\BuyerRequest;
use App\Services\Admin\website\BuyerBrowserService;
use Illuminate\View\View;

class BuyerBrowserController extends Controller
{
    protected $buyerBrowserService;

    public function __construct(BuyerBrowserService $buyerBrowserService)
    {
        $this->buyerBrowserService = $buyerBrowserService;
    }
    /**
     * Display a listing of the resource.
     */
    /* public function index()
    {
        $buyers = BuyerBrowser::orderBy('id', 'desc')->paginate(10);
        return view('admin.website_manage.home.buyer_brower.index', compact('buyers'));
    } */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.website_manage.home.buyer_browser.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BuyerRequest $request): RedirectResponse
    {
        $this->buyerBrowserService->store($request->validated());

        return redirect()
            ->route('buyers.show')
            ->with('success', 'Buyer section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(): View
    {
        $buyer = BuyerBrowser::first(); 
        return view('admin.website_manage.home.buyer_browser.show', compact('buyer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BuyerBrowser $buyer): View
    {
        return view('admin.website_manage.home.buyer_browser.edit', compact('buyer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BuyerRequest $request, BuyerBrowser $buyer)
    {
        $this->buyerBrowserService->update($buyer, $request->validated());

        return redirect()
            ->route('buyers.show')
            ->with('success', 'Buyer section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BuyerBrowser $buyer_browser): RedirectResponse
    {
        $this->buyerBrowserService->delete($buyer_browser);

        return redirect()
            ->route('buyers.show')
            ->with('success', 'Buyer section deleted successfully.');
    }

    // Restore a deleted category
    public function restore($id)
    {
        $this->faqService->restore($id);
        return redirect()->route('buyers.show')->with('success', 'Buyer restored successfully!');
    }
}
