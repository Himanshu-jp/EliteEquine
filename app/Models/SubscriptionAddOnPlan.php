<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionAddOnPlan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type', 'description', 'price', 'days'
    ];
}
