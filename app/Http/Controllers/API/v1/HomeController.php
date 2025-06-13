<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use App\Services\API\v1\HomeService;
use Illuminate\Support\Facades\Auth;

class HomeController extends BaseController
{
    protected HomeService $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return $this->sendError('Unauthorized', 'Invalid credentials.', 401);
        }

        $result = $this->homeService->getHomeData();

        if (!$result['success']) {
            return $this->sendError('Failed to fetch home data.', $result['message'], $result['code']);
        }

        return $this->sendResponse($result['data'], 'Home data fetched successfully.');
    }
}
