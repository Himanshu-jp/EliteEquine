<?php
namespace App\Services\Front;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductReviewService
{
    public function submitReview(array $data): Review
    {
        $imagePath = null;

        if (isset($data['image'])) {
            $imagePath = $data['image']->store('reviews', 'public');
        }

        return Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_owner_id' => $data['product_owner_id'],
            ],
            [
                'rating' => $data['rating'],
                'message' => $data['message'] ?? null,
                'image_path' => $imagePath,
            ]
        );
    }
}
