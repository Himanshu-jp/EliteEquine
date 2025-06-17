<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SubscriptionPlanRequest;
use App\Services\Admin\SubscriptionPlanService;
use App\Models\SubscriptionPlan;

class SubscriptionPlanController extends Controller
{
    protected $subsPlanService;

    public function __construct(SubscriptionPlanService $subsPlanService)
    {
        $this->subsPlanService = $subsPlanService;
    }

    public function index(Request $request)
    {
        // $plans = $this->subsPlanService->all();
        $query = SubscriptionPlan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                ->orWhere('subtitle', 'like', "%$search%")
                ->orWhere('price', 'like', "%$search%")
                ->orWhere('days', 'like', "%$search%")
                ->orWhere('post_limit', 'like', "%$search%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $plans = $query->orderBy('id', 'desc')->paginate(10);

        // Get unique types for filter dropdown
        $types = SubscriptionPlan::select('type')->distinct()->pluck('type');
        return view('admin.subscription_plans.index', compact('plans', 'types'));
    }

    public function create()
    {
        return view('admin.subscription_plans.create');
    }

    public function store(SubscriptionPlanRequest $request)
    {
     
        $data = $request->validated();
        $this->subsPlanService->create($data);

        return redirect()->route('subscription_plans.index')
                         ->with('success', 'Subscription plan created successfully.');
    }

    public function edit($id)
    {
        $subscriptionPlan = $this->subsPlanService->find($id);
        return view('admin.subscription_plans.edit', compact('subscriptionPlan'));
    }

    public function show($id)
    {
        $subscriptionPlan = $this->subsPlanService->find($id);
        return view('admin.subscription_plans.show', compact('subscriptionPlan'));
    }

    public function update(SubscriptionPlanRequest $request, SubscriptionPlan $subscriptionPlan)
    {
        $data = $request->validated();
        $this->subsPlanService->update($subscriptionPlan, $data);

        return redirect()->route('subscription_plans.index')
                         ->with('success', 'Subscription plan updated successfully.');
    }

    public function destroy($id)
    {
        $this->subsPlanService->destroy($id);

        return redirect()->route('subscription_plans.index')
                         ->with('success', 'Subscription plan deleted successfully.');
    }

    public function restore($id)
    {
        $this->subsPlanService->restore($id);

        return redirect()->route('subscription_plans.index')
                         ->with('success', 'Subscription plan restored successfully!');
    }
}
