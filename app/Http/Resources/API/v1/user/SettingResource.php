<?php

namespace App\Http\Resources\API\v1\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_hide_phone' => $this->is_hide_phone,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'youtube' => $this->youtube,
            'linkedin' => $this->linkedin,
            'instagram' => $this->instagram,
            'website' => $this->website,
            'description' => $this->description,
            'currency' => $this->currency,
            'precise_location' => $this->precise_location,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'street' => $this->street,
            'agree' => $this->agree,
            'banners' => $this->banners, 
            'latitude' => $this->latitude, 
            'longitude' => $this->longitude, 

             // UserDetailAlert data as a key-value meta structure
            'user_detail_alerts' => $this->formatAlerts(),
        ];
    }

    /**
     * Format alerts as key => [sms, mobile, email]
     *
     * @return array<string, array>
     */
    protected function formatAlerts(): array
    {
        $alertData = [];

        foreach ($this->userDetailAlert ?? [] as $alert) {
            $alertData[$alert->meta_key] = [
                'sms' => $alert->sms,
                'mobile' => $alert->mobile,
                'email' => $alert->email,
            ];
        }

        return $alertData;
    }
}
