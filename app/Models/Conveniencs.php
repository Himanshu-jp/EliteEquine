<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Conveniencs extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'userid',
        'ticket_id',
        'ticket_type',
        'group_name',
        'group_image',
        'type',
        'last_message',
        'is_block',
        'is_block_user_id',
    ];

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];


    public function chatuser(){
        return $this->hasMany(ChatUser::class,'convenience_id','id')->select('convenience_id', 'user_id','is_user_online','is_user_delete','chat_user');
    }
   
    public function chat(){
        return $this->hasMany(Chat::class,'convenience_id','id')->where('is_read',0);
    }


}
