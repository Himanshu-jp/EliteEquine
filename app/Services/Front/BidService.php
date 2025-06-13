<?php
namespace App\Services\Front;

use App\Models\ProductBid;

class BidService
{
    public function create(array $data): ProductBid
    {
        return ProductBid::create([
            'user_id' => $data['user_id'],
            'product_id' => $data['product_id'],
            'amount' => $data['amount'],
        ]);
    }
}
