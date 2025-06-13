<?php

namespace App\Http\Resources\API\v1\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\v1\user\UserResource;
class ThreadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {  
        return [

                "id" => $this->id,
                "convenience_id" => $this->convenience_id,
                "user_id" =>  $this->user_id,
                "is_user_online" =>  $this->is_user_online,
                "is_user_delete" =>  $this->is_user_delete,
                "total_unread"=>$this->total_unread,
                "last_message" =>  $this->room->last_message,
                "updated_at" =>  $this->room->updated_at,
                "chatuser"  => new UserResource($this->getUser)
        ];
        //return parent::toArray($request);
    }
}
