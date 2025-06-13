<?php
namespace App\Services\Admin;

use App\Models\SubscriptionAddOnPlan;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanAddonService
{
    public function all()
    {
        return SubscriptionAddOnPlan::latest()->paginate(10);
    }

    public function create(array $data)
    {
        return SubscriptionAddOnPlan::create($data);
    }

    public function find($id)
    {
        return SubscriptionAddOnPlan::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $addon = SubscriptionAddOnPlan::findOrFail($id);
        $addon->update($data);
        return $addon;
    }

    public function destroy($id)
    {
        SubscriptionAddOnPlan::findOrFail($id)->delete();
    }

    public function restore($id)
    {
        $addon = SubscriptionAddOnPlan::withTrashed()->findOrFail($id);
        $addon->restore();
    }
}
