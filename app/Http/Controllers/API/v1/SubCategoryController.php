<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\API\v1\SubcategoryService;
use App\Http\Requests\API\v1\SubcategoryListRequest;
use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\JsonResponse;

class SubCategoryController extends BaseController
{
    protected SubcategoryService $subcategoryService;

    public function __construct(SubcategoryService $subcategoryService)
    {
        $this->subcategoryService = $subcategoryService;
    }

    /**
     * Get all subcategories by category ID
     *
     * @param SubcategoryListRequest $request
     * @return JsonResponse
     */
    public function index(SubcategoryListRequest $request): JsonResponse
    {
        $result = $this->subcategoryService->getByCategoryId($request->category_id);

        if (!$result['success']) {
            return $this->sendError('Failed to fetch subcategories.', $result['message'], $result['code']);
        }

        return $this->sendResponse($result['data'], 'Subcategories fetched successfully.');
    }
}
