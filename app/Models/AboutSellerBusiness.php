<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSellerBusiness extends Model
{
    protected $fillable = [
        /* 'title',
        'description', */
        'image',
        
        'listing_icon',
        'listing_title',
        'listing_content',

        'track_icon',
        'track_title',
        'track_content',

        'featured_icon',
        'featured_title',
        'featured_content',

        'post_icon',
        'post_title',
        'post_content',
    ];

}
