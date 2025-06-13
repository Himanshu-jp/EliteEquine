<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetailAlert extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'user_detail_alerts';

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];

    //--when we store records as mass storage then we have to use this fillable method ---//

    protected $fillable = [
        'user_id',
        'user_detail_id',
        'meta_key',
        'sms',
        'mobile',
        'email',
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->select('id','email','name','username');
    }
    
    public function user_details()
    {
        return $this->belongsTo(UserDetails::class,'user_detail_id')->select('id','email','first_name','last_name');
    }

}
