<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyerFaq extends Model
{
    use SoftDeletes;

    protected $table = 'buyer_faqs';

    protected $fillable = [
        'questions',
        'answers',
    ];

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];
}
