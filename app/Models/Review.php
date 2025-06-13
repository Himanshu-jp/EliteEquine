<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'product_owner_id', 'rating', 'message', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->select('id','email','name','username', 'profile_photo_path');
    }

    public function ownerUser()
    {
        return $this->belongsTo(User::class,'product_owner_id')->select('id','email','name','username');
    }
}
