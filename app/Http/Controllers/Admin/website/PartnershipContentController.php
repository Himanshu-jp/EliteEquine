<?php

namespace App\Http\Controllers\Admin\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\website\PartnershipRequest;
use App\Models\PartnershipContent;
use App\Services\Admin\website\PartnershipService;

class PartnershipContentController extends Controller
{
   protected $partnershipService;

    public function __construct(PartnershipService $partnershipService)
    {
        $this->partnershipService = $partnershipService;
    }

    public function create()
    {
        return view('admin.website_manage.partnership.partner_content.create');
    }

    public function store(PartnershipRequest $request)
    {
        $data = $request->validated();
        $this->partnershipService->create($data);
        return redirect()->route('partner_content.show')->with('success', 'Partnership content created successfully.');
    }

    public function edit($id)
    {
        $partnership = $this->partnershipService->find($id);
        return view('admin.website_manage.partnership.partner_content.edit', compact('partnership'));
    }

    public function show()
    {
        $partnership = PartnershipContent::first(); 
        return view('admin.website_manage.partnership.partner_content.show', compact('partnership'));
    }

    public function update(PartnershipRequest $request, PartnershipContent $paertner_content)
    {
        $data = $request->validated();
        
        $this->partnershipService->update($paertner_content, $data);

        return redirect()->route('partner_content.show')->with('success', 'Partnership content updated successfully.');
    }

}
