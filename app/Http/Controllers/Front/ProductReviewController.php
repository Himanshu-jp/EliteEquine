<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Front\RateProductRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\Front\ProductReviewService;
use Illuminate\Http\JsonResponse;

class ProductReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ProductReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function rate(RateProductRequest $request): JsonResponse
    {
        if(Auth::check() == false)
        {
            return response()->json(['success' => false, 'message' => 'Please login first.']);
        }

        $data = $request->validated();
        
        if(Auth::user()->id == $data['product_owner_id'])
        {
            return response()->json(['success' => false, 'message' => 'You are not able to add review.']);
        }
        
        $this->reviewService->submitReview($data);

        return response()->json(['success' => true, 'message' => 'Review submitted successfully.']);
    }
}
