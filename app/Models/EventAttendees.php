<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class EventAttendees extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'event_id','amount','currency','payment_status','stripe_session_id','stripe_payment_intent'];

    public function Event()
    {
        return $this->belongsTo(Community::class,'event_id')->select('id', 'title','date','time','location','image');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name','username','email','profile_photo_path');
    }

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];
}
