<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Community extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'title', 'requirement', 'image','date','time','event_around','price','location'];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name','username','email','profile_photo_path');
    }

    public function join()
    {
        return $this->hasMany(EventAttendees::class, 'event_id');
    }

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];
}
