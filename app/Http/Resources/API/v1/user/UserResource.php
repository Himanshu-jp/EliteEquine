<?php

namespace App\Http\Resources\API\v1\user;

use Illuminate\Http\Resources\Json\JsonResource;
class UserResource extends JsonResource
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
                "email" => $this->email,
                "name" => $this->name,
                "username" => $this->name,
                "email" => $this->email,
                "profile_photo_path" => $this->profile_photo_path ? asset('storage/'.$this->profile_photo_path) : asset('front/auth/assets/img/user-img.png'),
        ];
        //return parent::toArray($request);
    }
}
