<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SubscriptionPlanAddonRequest;
use App\Services\Admin\SubscriptionPlanAddonService;
use App\Models\SubscriptionAddOnPlan;

class SubscriptionPlanAddonController extends Controller
{
    protected $subPlanAddonService;

    public function __construct(SubscriptionPlanAddonService $subPlanAddonService)
    {
        $this->subPlanAddonService = $subPlanAddonService;
    }

    public function index()
    {
        $addons = $this->subPlanAddonService->all();
        return view('admin.subscription_addons.index', compact('addons'));
    }

    public function create()
    {
        return view('admin.subscription_addons.create');
    }

    public function store(SubscriptionPlanAddonRequest $request)
    {
        $this->subPlanAddonService->create($request->validated());
        return redirect()->route('subscription-addons.index')->with('success', 'Addon created successfully.');
    }

    public function edit($id)
    {
        $addon = $this->subPlanAddonService->find($id);
        return view('admin.subscription_addons.edit', compact('addon'));
    }
    
    public function show($id)
    {
        $subscriptionAddon = $this->subPlanAddonService->find($id);
        return view('admin.subscription_addons.show', compact('subscriptionAddon'));
    }

    public function update(SubscriptionPlanAddonRequest $request, $id)
    {
        $this->subPlanAddonService->update($id, $request->validated());
        return redirect()->route('subscription-addons.index')->with('success', 'Addon updated successfully.');
    }

    public function destroy($id)
    {
        $this->subPlanAddonService->destroy($id);
        return redirect()->route('subscription-addons.index')->with('success', 'Addon deleted successfully.');
    }

    public function restore($id)
    {
        $this->subPlanAddonService->restore($id);
        return redirect()->route('subscription-addons.index')->with('success', 'Addon restored successfully.');
    }
}
