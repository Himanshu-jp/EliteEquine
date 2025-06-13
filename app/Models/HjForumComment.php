<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HjForumComment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'forum_id',
        'comment',
        'name',
        'email',
        'website',
        'forum_comment_id',
    ];

    public function forum()
    {
        return $this->belongsTo(HjForum::class, 'forum_id')->select('id', 'title', 'slug', 'price', 'currency');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id', 'name','profile_photo_path');
    }

     // Parent comment
    public function parent()
    {
        return $this->belongsTo(HjForumComment::class, 'forum_comment_id')->where('forum_comment_id',null);
    }

    // Child comments
    public function children()
    {
        return $this->hasMany(HjForumComment::class, 'forum_comment_id')->where('forum_comment_id','!=',null)->orderBy('id', 'Desc');
    }

}
