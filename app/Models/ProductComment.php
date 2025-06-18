<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductComment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'email',
        'title',
        'comment',
        'image',
        'website',
        'product_comment_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->select('id', 'title', 'slug', 'price', 'currency');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id', 'name', 'profile_photo_path');
    }

     // Parent comment
    public function parent()
    {
        return $this->belongsTo(ProductComment::class, 'product_comment_id')->where('product_comment_id',null);
    }

    // Child comments
    public function children()
    {
        return $this->hasMany(ProductComment::class, 'product_comment_id')->where('product_comment_id','!=',null)->orderBy('id', 'Desc');
    }

}
