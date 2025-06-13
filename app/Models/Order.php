<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'product_id', 'price', 'stripe_session_id', 'stripe_payment_intent', 'payment_status', 'order_status'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->select('id', 'title', 'slug', 'price', 'currency');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id', 'name','profile_photo_path', 'email', 'phone_no');
    }
}
