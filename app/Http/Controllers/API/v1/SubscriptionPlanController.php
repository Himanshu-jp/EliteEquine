<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\API\v1\SubscriptionService;
use App\Http\Requests\API\v1\SubscriptionPlanRequest;
use App\Http\Controllers\API\v1\BaseController;

class SubscriptionPlanController extends BaseController
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Get all categories
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // $result = $this->subscriptionService->getAllPlans($request->type);
        $result = $this->subscriptionService->getAllPlans();

        if (!$result['success']) {
            return $this->sendError('Failed to fetch categories.', $result['message'], $result['code']);
        }

        return $this->sendResponse($result['data'], 'Subscription plan fetched successfully.', $result['total']);
    }
}
