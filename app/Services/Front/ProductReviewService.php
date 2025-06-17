<?php
namespace App\Services\Front;

use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductReviewService
{
    public function submitReview(array $data)
    {
        $imagePath = null;

        if (isset($data['image'])) {
            $imagePath = $data['image']->store('reviews', 'public');
        }

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_owner_id' => $data['product_owner_id'],
            ],
            [
                'rating' => $data['rating'],
                'message' => $data['message'] ?? null,
                'image' => $imagePath,
            ]
        );
        $avg = Review::where('product_owner_id', $data['product_owner_id'])->avg('rating');
        User::where('id',$data['product_owner_id'])->update(['avgRating'=>$avg]);
    }
}
