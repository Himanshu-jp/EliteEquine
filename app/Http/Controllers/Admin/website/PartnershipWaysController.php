<?php

namespace App\Http\Controllers\Admin\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\website\PartnershipWaysRequest;
use App\Models\PartnershipWay;
use App\Services\Admin\website\PartnershipService;

class PartnershipWaysController extends Controller
{
    protected $partnershipService;

    public function __construct(PartnershipService $partnershipService)
    {
        $this->partnershipService = $partnershipService;
    }

    public function index()
    {
        $partnershipWays = PartnershipWay::orderBy('id', 'desc')->paginate(10);
        return view('admin.website_manage.partnership.ways_to.index', compact('partnershipWays'));
    }

    public function create()
    {
        return view('admin.website_manage.partnership.ways_to.create');
    }

    public function store(PartnershipWaysRequest $request)
    {
        $data = $request->validated();
        $this->partnershipService->waysCreate($data);
        return redirect()->route('partner_ways.index')->with('success', 'Partnership Way created successfully.');
    }

    public function edit($id)
    {
        $way = $this->partnershipService->waysFind($id);
        return view('admin.website_manage.partnership.ways_to.edit', compact('way'));
    }

    public function show($id)
    {
        $way = $this->partnershipService->waysFind($id);
        return view('admin.website_manage.partnership.ways_to.show', compact('way'));
    }

    public function update(PartnershipWaysRequest $request, PartnershipWay $partnershipWay)
    {
        $data = $request->validated();
        $this->partnershipService->waysUpdate($partnershipWay, $data);
        return redirect()->route('partner_ways.index')->with('success', 'Partnership Way updated successfully.');
    }

    public function destroy($id)
    {
        $this->partnershipService->waysDelete($id);
        return redirect()->route('partner_ways.index')->with('success', 'Partnership Way deleted successfully.');
    }
}
