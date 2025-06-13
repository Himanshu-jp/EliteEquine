<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeAbout extends Model
{
    protected $table = 'home_abouts'; // Change this to your actual table name
    protected $fillable = [
        'title',
        'description',
        'image'
    ];
}
