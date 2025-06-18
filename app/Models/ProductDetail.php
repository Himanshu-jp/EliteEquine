<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'height_id',
        'sex_id',
        'green_eligibilitie_id',
        'fromdate',
        'todate',
        'bid_min_price',
        'sale_price',
        'lease_price',
        'trainer',
        'sleep',
        'facility',
        'sirebloodline',
        'dambloodline',
        'usef',
        'pedigree_chart',
        'around',
        'age',
        'fromlocation',
        'tolocation',
        'stalls_available_haulings',
        'price',
        'hourly_price',
        'fixed_price',
        'location',
        'precise_location',
        'country',
        'state',
        'city',
        'street',
        'latitude',
        'longitude',
        'banner',
        'agree',
        'phone',
        'stalls_available',
        'daily_board_rental_rate',
        'weekly_board_rental_rate',
        'monthly_board_rental_rate',
        'sale_cost', 
        'salary', 
        'haulings_location_from', 
        'haulings_location_to',
        'realtor',
        'property_manager',
        'time_slot'
        'trail_latitude',
        'trail_longitude',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->select('id', 'title', 'slug', 'price', 'currency');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name','profile_photo_path');
    }

}
