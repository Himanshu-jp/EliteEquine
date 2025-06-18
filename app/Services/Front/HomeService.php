<?php

namespace App\Services\Front;

use App\Models\ProductComment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactAdOwner;
use App\Models\Product;
use App\Models\ProductEnquiry;
use App\Models\ProductReport;

class HomeService
{
    // Store a new comment
    public function submitReport($data,$user)
    {
        $data['user_id'] = $user->id;
        $data['product_id'] = $data['product_id'];
        $data['message'] = $data['message'];
        return ProductReport::create($data);
    }
    
    // Store a new comment
    public function storeComment($data,$user)
    {
        if (isset($data['file'])) {
            $data['image'] = $data['file']->store('comment', 'public');
        }
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

    // Store a new comment
    public function contactAdOwner($data)
    {
        $product = Product::with('user')->where('id', $data['product_id'])->first();
        $link = "";
        if($product->category_id==1){
            $link = route('horseDetails', $product->id);
        } else if($product->category_id==2) {
            $link = route('equipmentDetails', $product->id);
        }
        else if($product->category_id==3){
            $link = route('barnsDetails', $product->id);
        }
        else {
            $link = route('serviceDetails', $product->id);
        }

        $data['product_id'] = $data['product_id'];
        $data['name'] = $data['contactName'];
        $data['email'] = $data['contactEmail'];
        $data['message'] = $data['contactMessage'];
        $enquiry = ProductEnquiry::create($data);

        $mailData = [
            'link' => $link,
            'name' => $data['contactName'],
            'email' => $data['contactEmail'],
            'message' => $data['contactMessage']
        ];
        $result = Mail::to($product->user->email)->send(new ContactAdOwner($mailData));
        return true;
    }
    
}
