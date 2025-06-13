<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMSPage extends Model
{
    protected $table = 'cms_pages';
    protected $fillable = ['name', 'slug', 'content', 'image'];
}
