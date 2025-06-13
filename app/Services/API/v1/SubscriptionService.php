<?php

namespace App\Services\API\v1;

use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\API\v1\user\SubscriptionResource;

class SubscriptionService
{
    /**
     * Get all subscription plans
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPlans()
    {
        if (!Auth::guard('sanctum')->check()) {
            return [
                'success' => false,
                'message' => 'Invalid credentials.',
                'code' => 401
            ];
        }

        $categories = SubscriptionPlan::orderBy('title');
        $total = $categories->count();
        $categories = $categories->get();

        if ($categories->isNotEmpty()) {
            return [
                'success' => true,
                'data' => SubscriptionResource::collection($categories),
                'total' => $total,
                'code' => 200
            ];
        }

        return [
            'success' => false,
            'message' => 'No categories found.',
            'code' => 200
        ];
    }
}
