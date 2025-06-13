<?php
namespace App\Services\Front;

use App\Models\ProductRating;

class RatingService
{
    public function storeRating($userId, array $data): ProductRating
    {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('product_ratings', 'public');
        }
        return ProductRating::create($data);
    }
}
