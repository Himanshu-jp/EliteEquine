<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBid extends Model
{
    protected $fillable = ['user_id', 'product_id', 'amount', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->select('id', 'title', 'slug', 'price', 'currency');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name','profile_photo_path', 'email', 'phone_no');
    }
}
