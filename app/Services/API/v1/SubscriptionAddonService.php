<?php

namespace App\Services\API\v1;

use App\Http\Resources\API\v1\user\SubscriptionAddonResource;
use App\Models\SubscriptionAddOnPlan;
use Illuminate\Support\Facades\Auth;

class SubscriptionAddonService
{
    public function getAllAddons(): array
    {
        if (!Auth::guard('sanctum')->check()) {
            return [
                'success' => false,
                'message' => 'Unauthorized access.',
                'code' => 401
            ];
        }

        $addons = SubscriptionAddOnPlan::orderBy('id', 'desc')->get();

        if ($addons->isNotEmpty()) {
            return [
                'success' => true,
                'data' => SubscriptionAddonResource::collection($addons),
                'code' => 200,
            ];
        }

        return [
            'success' => false,
            'message' => 'No addons found.',
            'code' => 200,
        ];
    }
}
