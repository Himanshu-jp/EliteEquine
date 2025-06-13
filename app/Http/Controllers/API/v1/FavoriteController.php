<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\API\v1\FavoriteService;
use App\Http\Requests\API\v1\FavoriteRequest;
use App\Http\Requests\API\v1\FavoriteDeleteRequest;
use App\Http\Requests\API\v1\FavoriteListRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\v1\BaseController;

class FavoriteController extends BaseController
{
    protected FavoriteService $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    /**
     * Get all favorites for authenticated user
     */
    public function index(FavoriteListRequest $request): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return $this->sendError('Unauthorized', 'Invalid credentials.', 401);
        }

        $result = $this->favoriteService->index($request->page, $user);

        if (!$result['success']) {
            return $this->sendError('Failed to fetch favorite.', $result['message'], $result['code']);
        }

        return $this->sendResponse($result['data'], 'Favorite fetched successfully.', $result['total']);
    }

    /**
     * Add a product to favorites
     */
    public function store(FavoriteRequest $request): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return $this->sendError('Unauthorized', 'Invalid credentials.', 401);
        }

        $result = $this->favoriteService->add($request->product_id, $user);

        if (!$result['success']) {
            return $this->sendError('Failed to fetch favorite.', $result['message'], $result['code']);
        }

        return $this->sendResponse($result['data'], 'Favorite added successfully.');
    }

    /**
     * Remove a favorite by ID
     */
    public function destroy(FavoriteDeleteRequest $request): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return $this->sendError('Unauthorized', 'Invalid credentials.', 401);
        }

        $result = $this->favoriteService->delete($request->favorite_id, $user);
        if (!$result['success']) {
            return $this->sendError('Failed to fetch favorite.', $result['message'], $result['code']);
        }

        return $this->sendResponse($result['data'], 'Favorite deleted successfully.');
    }
}
