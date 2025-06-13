<?php

namespace App\Http\Controllers\Admin\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\website\SellerBusinessRequest;
use App\Models\SellerBusiness;
use App\Services\Admin\website\SellerBusinessService;

class SellerBusinessController extends Controller
{
    protected $businessService;

    public function __construct(SellerBusinessService $businessService)
    {
        $this->businessService = $businessService;
    }

    // Show the first (or single) seller business record - adjust if you want a list
    public function show()
    {
        $business = SellerBusiness::first();
        return view('admin.website_manage.home.seller_business.show', compact('business'));
    }

    public function create()
    {
        return view('admin.website_manage.home.seller_business.create');
    }

    public function store(SellerBusinessRequest $request)
    {
        $data = $request->validated();
        $this->businessService->create($data);

        return redirect()->route('seller-business.show')->with('success', 'Seller Business content created successfully.');
    }

    public function edit($id)
    {
        $business = $this->businessService->find($id);
        return view('admin.website_manage.home.seller_business.edit', compact('business'));
    }

    public function update(SellerBusinessRequest $request, $id)
    {
        $data = $request->validated();
        $this->businessService->update($id, $data);

        return redirect()->route('seller-business.show')->with('success', 'Seller Business content updated successfully.');
    }

    // Optional destroy method, uncomment if needed
    /*
    public function destroy($id)
    {
        $this->businessService->delete($id);
        return redirect()->route('seller_business.index')->with('success', 'Seller Business content deleted successfully.');
    }
    */
}
