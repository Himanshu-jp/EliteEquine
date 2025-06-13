<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CommonMaster extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'type', 'status', 'category_id'];

    /**
     * category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
