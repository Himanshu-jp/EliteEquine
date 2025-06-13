<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\API\v1\user\SubscriptionAddonResource;
use App\Services\API\v1\SubscriptionAddonService;
use App\Models\SubscriptionAddOnPlan;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\v1\BaseController;

class SubscriptionAddonController extends BaseController
{
    protected SubscriptionAddonService $addonService;

    public function __construct(SubscriptionAddonService $addonService)
    {
        $this->addonService = $addonService;
    }

    public function index(): JsonResponse
    {
        $result = $this->addonService->getAllAddons();

        if (!$result['success']) {
            return $this->sendError('Failed to fetch addons.', $result['message'], $result['code']);
        }

        return $this->sendResponse($result['data'], 'Addons fetched successfully.');
    }
}
