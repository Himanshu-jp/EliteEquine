<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetails extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'user_details';

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];

    //--when we store records as mass storage then we have to use this fillable method ---//

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'is_hide_phone',
        'facebook',
        'twitter',
        'youtube',
        'linkedin',
        'instagram',
        'website',
        'description',
        'currency',
        'precise_location',
        'country',
        'state',
        'city',
        'street',
        'banners',
        'agree',
        'latitude',
        'longitude'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->select('id','email','name','username', 'profile_photo_path');
    }

    /**
     * Relationship: Get user detail.
     */
    public function userDetailAlert()
    {
        return $this->hasMany(UserDetailAlert::class, 'user_detail_id');
    }
}
