<?php

namespace App\Services\API\v1;

use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\API\v1\user\SubcategoryResource; // Use the correct resource for subcategories

class SubcategoryService
{
    public function getByCategoryId(int $categoryId)
    {
        if (!Auth::guard('sanctum')->check()) {
            return [
                'success' => false,
                'message' => 'Invalid credentials.',
                'code'    => 401
            ];
        }

        // Fetch subcategories by categoryId
        $subCategory = SubCategory::where('category_id', $categoryId)
                                   ->orderBy('name')
                                   ->get();

        if ($subCategory->isNotEmpty()) {
            return [
                'success' => true,
                'data'    => SubcategoryResource::collection($subCategory),
                'code'    => 200
            ];
        }

        return [
            'success' => false,
            'message' => 'No subcategories found.',
            'code'    => 200
        ];
    }
}
