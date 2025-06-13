<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\API\v1\CategoryService;
use App\Http\Controllers\API\v1\BaseController;

class CategoryController extends BaseController
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Get all categories
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->categoryService->getAll();

        if (!$result['success']) {
            return $this->sendError('Failed to fetch categories.', $result['message'], $result['code']);
        }

        return $this->sendResponse($result['data'], 'Categories fetched successfully.');
    }
}
