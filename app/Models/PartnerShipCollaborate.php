<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PartnerShipCollaborate extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['image'];
}
