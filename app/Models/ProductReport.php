<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'message'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->select('id', 'title', 'slug', 'price', 'currency');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id', 'name', 'profile_photo_path');
    }

}
