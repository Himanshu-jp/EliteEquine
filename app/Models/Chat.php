<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Chat extends Model
{
    use SoftDeletes;

    protected $fillable = ['convenience_id', 'chat_user_id','from_id','to_id','replay_id','message','file','file_type','thumbnail','is_read','is_clear'];

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];


    public function sender()
    {
        return $this->hasOne(User::class,'id','from_id')->select('id', 'name','username','email','profile_photo_path');;;
    }
    
    public function receiver()
    {
        return $this->hasOne(User::class,'id','to_id')->select('id', 'name','username','email','profile_photo_path');;;
    }
}
