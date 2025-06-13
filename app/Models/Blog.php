<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'category_id', 'slug', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id', 'name');
    }

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];
}
