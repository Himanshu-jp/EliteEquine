<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSubCategory extends Model
{
    protected $table = 'product_subcategory';
    // use SoftDeletes;
    protected $fillable = [
        'product_id',
        'category_id'
    ];

  
    public function category()
    {
        return $this->belongsTo(SubCategory::class, 'category_id')->select('id', 'name');
    }
}
