<?php

namespace App\Http\Controllers\Admin\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\website\PartnerShipCollaborateRequest;
use App\Models\PartnerShipCollaborate;
use App\Services\Admin\website\PartnershipService;

class PartnerShipCollaborateController extends Controller
{
    protected $partnershipService;

    public function __construct(PartnershipService $partnershipService)
    {
        $this->partnershipService = $partnershipService;
    }

    public function index()
    {
        $collaborates = $this->partnershipService->collaborateAll();
        return view('admin.website_manage.partnership.collaboate.index', compact('collaborates'));
    }

    public function create()
    {
        return view('admin.website_manage.partnership.collaboate.create');
    }

    public function store(PartnerShipCollaborateRequest $request)
    {
        $data = $request->validated();
        
        $this->partnershipService->collaborateCreate($data);
        return redirect()->route('partner_collaborate.index')->with('success', 'Partner content created successfully.');
    }

    public function edit($id)
    {
        $collaborate = $this->partnershipService->collaborateFind($id);
        return view('admin.website_manage.partnership.collaboate.edit', compact('collaborate'));
    }

    public function update(PartnerShipCollaborateRequest $request, $id)
    {
        $data = $request->validated();

        $this->partnershipService->collaborateUpdate($id, $data);
        return redirect()->route('partner_collaborate.index')->with('success', 'Partner content updated successfully.');
    }

    public function destroy($id)
    {
        $this->partnershipService->collaborateDestroy($id);
        return redirect()->route('partner_collaborate.index')->with('success', 'Partnership Collaborate deleted successfully.');
    }

    public function restore($id)
    {
        $this->partnershipService->collaborateRestore($id);
        return redirect()->route('partner_collaborate.index')->with('success', 'Partnership Collaborate restored successfully.');
    }
}
