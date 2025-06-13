<?php

namespace App\Services\API\v1;

use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use App\Http\Resources\API\v1\user\CategoryResource;
use App\Http\Resources\API\v1\user\ProductResource;
use App\Http\Resources\API\v1\user\BlogResource;

class HomeService
{
    public function getHomeData()
    {
        $homeData = [];

        // Categories
        $categories = Category::orderBy('id', 'asc')->get();
        if ($categories->isNotEmpty()) {
            $homeData['categories'] = CategoryResource::collection($categories);

            foreach ($categories as $category) {
                $products = Product::withoutTrashed()->where('category_id', $category->id)
                    ->orderBy('id', 'desc')
                    ->take(3)
                    ->get();

                if ($products->isNotEmpty()) {
                    switch ($category->id) {
                        case 1:
                            $homeData['horses'] = ProductResource::collection($products);
                            break;
                        case 2:
                            $homeData['equipmentApparel'] = ProductResource::collection($products);
                            break;
                        case 3:
                            $homeData['barnsHousing'] = ProductResource::collection($products);
                            break;
                        case 4:
                            $homeData['servicesJobs'] = ProductResource::collection($products);
                            break;
                    }
                }
            }
        }

        // Blogs
        $blogs = Blog::withoutTrashed()->orderBy('id', 'desc')->take(3)->get();
        if ($blogs->isNotEmpty()) {
            $homeData['blogs'] = BlogResource::collection($blogs);
        }

        // Final response
        if (!empty($homeData)) {
            return [
                'success' => true,
                'data' => $homeData,
                'code' => 200
            ];
        }

        return [
            'success' => false,
            'message' => 'No home data found.',
            'code' => 200
        ];
    }
}
