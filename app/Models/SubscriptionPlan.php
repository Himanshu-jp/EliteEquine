<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'price',
        'days',
        'description',
        'type',
        'post_limit',
        'stripe_product_id', 
        'price_id'
    ];
}
