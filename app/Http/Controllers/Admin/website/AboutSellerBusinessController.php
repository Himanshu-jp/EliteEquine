<?php

namespace App\Http\Controllers\Admin\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\website\AboutSellerBusinessRequest;
use App\Models\AboutSellerBusiness;
use App\Services\Admin\website\AboutService;

class AboutSellerBusinessController extends Controller
{
    protected $aboutService;

    public function __construct(AboutService $aboutService)
    {
        $this->aboutService = $aboutService;
    }

    // Show the first (or single) seller business record - adjust if you want a list
    public function show()
    {
        $business = AboutSellerBusiness::first();
        return view('admin.website_manage.about_us.seller_business.show', compact('business'));
    }

    public function create()
    {
        return view('admin.website_manage.about_us.seller_business.create');
    }

    public function store(AboutSellerBusinessRequest $request)
    {
        $data = $request->validated();
        $this->aboutService->sellerCreate($data);

        return redirect()->route('about-seller-business.show')->with('success', 'About seller business content created successfully.');
    }

    public function edit($id)
    {
        $business = $this->aboutService->sellerFind($id);
        return view('admin.website_manage.about_us.seller_business.edit', compact('business'));
    }

    public function update(AboutSellerBusinessRequest $request, $id)
    {
        $data = $request->validated();
        $this->aboutService->sellerUpdate($id, $data);

        return redirect()->route('about-seller-business.show')->with('success', 'About seller business content updated successfully.');
    }

    // Optional destroy method, uncomment if needed
    /*
    public function destroy($id)
    {
        $this->businessService->sellerDelete($id);
        return redirect()->route('aboput-seller-business.index')->with('success', 'About seller business content deleted successfully.');
    }
    */
}
