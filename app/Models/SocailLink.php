<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocailLink extends Model
{
    protected $table = 'socail_links';

    protected $fillable = [
        'android_app',
        'ios_app',
        'facebook',
        'tiktok',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
    ];
}
