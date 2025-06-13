<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Model
{
    use SoftDeletes;

    protected $table = 'newsletters';

    protected $fillable = [
        'email'
    ];

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];
}
