<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductLink extends Model
{
    // use SoftDeletes;
    protected $fillable = [
        'product_id',
        'type',
        'link'
    ];
}
