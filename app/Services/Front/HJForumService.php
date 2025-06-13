<?php
namespace App\Services\Front;

use App\Models\HjForum;
use App\Models\HjForumComment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HJForumService
{
    public function create($data,$user)
    {        
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('forum', 'public');
        }
        $data['user_id'] = $user->id; // Assuming you pass the user object
        $forum = HjForum::create($data);
        return $forum;
    }

    public function update($id,$data)
    {
        $forum = HjForum::where('id',$id)->first();
        // Handle image update
        if (isset($data['image'])) {
            if ($forum->image && Storage::disk('public')->exists($forum->image)) {
                Storage::disk('public')->delete($forum->image);
            }
            $data['image'] = $data['image']->store('forum', 'public');
        }        
        $forum = $forum->update($data);
        return $forum;
    }

    public function delete($id)
    {
        $forum = HjForum::where('id',$id)->delete();
    }


    // Store a new comment
    public function storeComment($data,$user)
    {
        if($user){
            $data['user_id'] = $user->id;
        }else{
            $data['user_id'] = null;
        }
        return HjForumComment::create($data);
    }
    
    // Store a new comment
    public function removeComment($id,$user)
    {
        return HjForumComment::where('id',$id)->delete();
    }

}
