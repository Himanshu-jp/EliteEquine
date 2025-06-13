<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ChatUser extends Model
{
    use SoftDeletes;

    protected $fillable = ['convenience_id', 'user_id','is_user_online','is_user_delete','chat_user'];

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];

    public function getUser(){
        return $this->hasOne(User::class,'id','user_id')->select('id', 'name','username','email','profile_photo_path','is_online','socket_id');
    }

    public function userdata()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id', 'name','username','email','profile_photo_path','is_online','socket_id');
    }
   
    public function room()
    {
        return $this->belongsTo(Conveniencs::class, 'convenience_id')->select('id', 'last_message','updated_at');
    }

    public function chat(){
        return $this->hasMany(Chat::class,'convenience_id','id')->where('is_read',0);
    }
}

