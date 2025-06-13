<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRelation extends Model
{
    // use SoftDeletes;
    protected $fillable = [
        'product_id',
        'common_master_id',
        'type',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->select('id', 'title', 'slug');
    }    

    public function commonMaster()
    {
        return $this->belongsTo(CommonMaster::class, 'common_master_id');
    }

}
