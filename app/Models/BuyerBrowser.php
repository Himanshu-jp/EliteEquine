<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyerBrowser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image'
    ];

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];
}
