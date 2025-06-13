<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ContactUs extends Model
{
    use SoftDeletes;

    protected $table = 'contact_us';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'user_id'
    ];

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];

    /**
     * Get the user who submitted the contact message.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
