<?php

namespace App\Services\Front;

use App\Models\ProductComment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HomeService
{
    // Store a new comment
    public function storeComment($data,$user)
    {
        if($user){
            $data['user_id'] = $user->id;
        }else{
            $data['user_id'] = null;
        }
        return ProductComment::create($data);
    }
    
    // Store a new comment
    public function removeComment($id,$user)
    {
        return ProductComment::where('id',$id)->delete();
    }
}
