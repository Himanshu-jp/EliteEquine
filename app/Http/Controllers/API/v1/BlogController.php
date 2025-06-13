<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\v1\BaseController;
use App\Http\Requests\API\v1\BlogListRequest;
use App\Services\API\v1\BlogService;
use Illuminate\Http\JsonResponse;

class BlogController extends BaseController
{
    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index(BlogListRequest $request): JsonResponse
    {
        $result = $this->blogService->getAllBlogs($request->page);

        if (!$result['success']) {
            return $this->sendError('Failed to fetch blogs.', $result['message'], $result['code']);
        }

        return $this->sendResponse($result['data'], 'Blogs fetched successfully.', $result['total']);
    }

    public function show($identifier): JsonResponse
    {
        $result = $this->blogService->getBlogByIdOrSlug($identifier);

        if (!$result['success']) {
            return $this->sendError('Failed to fetch blog.', $result['message'], $result['code']);
        }

        return $this->sendResponse($result['data'], 'Blog fetched successfully.');
    }
}
