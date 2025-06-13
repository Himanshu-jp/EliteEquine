<?php

namespace App\Services\API\v1;

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\API\v1\user\BlogResource;

class BlogService
{
    public function getAllBlogs(int $page = 1): array
    {
        if (!Auth::guard('sanctum')->check()) {
            return [
                'success' => false,
                'message' => 'Invalid credentials.',
                'code' => 401
            ];
        }

        $query = Blog::with('category')->orderBy('created_at', 'desc');

        $total = $query->count();
        $limit = 10;
        $page = max(1, (int) $page);

        // Calculate the index (offset)
        $index = ($page - 1) * $limit;

        $blogs = $query
            ->distinct()
            ->offset($index)
            ->limit($limit)
            ->get();
        // $blogs = $query->offset($index)->limit($limit)->get();

        if ($blogs->isNotEmpty()) {
            return [
                'success' => true,
                'data' => BlogResource::collection($blogs),
                'code' => 200,
                'total' => $total,
            ];
        }

        return [
            'success' => false,
            'message' => 'No blogs found.',
            'code' => 200,
        ];
    }

    public function getBlogByIdOrSlug($identifier): array
    {
        $blog = Blog::with('category')
            ->where('id', $identifier)
            ->orWhere('slug', $identifier)
            ->first();

        if ($blog) {
            return [
                'success' => true,
                'data' => new BlogResource($blog),
                'code' => 200,
            ];
        }

        return [
            'success' => false,
            'message' => 'Blog not found.',
            'code' => 404,
        ];
    }
}
