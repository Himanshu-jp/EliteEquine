<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductEnquiry extends Model
{
    use SoftDeletes;
    protected $table = 'product_enquires';
    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'email',
        'message',
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
