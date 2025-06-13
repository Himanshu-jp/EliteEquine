<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'categories';

    //--when we store records as mass storage then we have to use this fillable method ---//

    protected $fillable = [
        'name','image','slug'
    ];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];
    
    public function types()
    {
        return $this->hasMany(CommonMaster::class); 
    }
}
