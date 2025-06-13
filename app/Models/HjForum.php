<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HjForum extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'title', 'description', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name','username','email','profile_photo_path');
    }

    public function comments()
    {
        return $this->hasMany(HjForumComment::class, 'forum_id')
                    ->whereNull('forum_comment_id')
                    ->with('children')
                    ->orderBy('id', 'desc');
    }

    // Cast deleted_at to datetime
    protected $dates = ['deleted_at'];
}
