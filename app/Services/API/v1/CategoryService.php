<?php

namespace App\Services\API\v1;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\API\v1\user\CategoryResource;

class CategoryService
{
    public function getAll(): array
    {
        if (!Auth::guard('sanctum')->check()) {
            return [
                'success' => false,
                'message' => 'Invalid credentials.',
                'code' => 401
            ];
        }

        $categories = Category::orderBy('name')->orderBy('name')->get();

        if ($categories->isNotEmpty()) {
            return [
                'success' => true,
                'data' => CategoryResource::collection($categories),
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
