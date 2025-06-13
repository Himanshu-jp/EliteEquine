<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['user_id', 'product_id', 'service_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->select('id','email','name','username');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->select('id', 'title', 'slug', 'price', 'currency');
    }
}
