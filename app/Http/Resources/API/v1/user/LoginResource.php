<?php

namespace App\Http\Resources\API\v1\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'    => $this->id,
            'name'  => $this->name,
            'username'  => $this->username,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'bio' => $this->bio,
            'image_url' => $this->profile_photo_path ? asset('storage/' . $this->profile_photo_path)
            : asset('/images/default-user.png'),
            'token' => $this->token,
        ];
    }
}
