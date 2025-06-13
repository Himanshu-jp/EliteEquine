<?php

namespace App\Http\Resources\API\v1\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CategoryFourProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'fromdate' => $this->fromdate ? Carbon::parse($this->fromdate)->toDateString() : null,
            'todate' => $this->todate ? Carbon::parse($this->todate)->toDateString() : null,
            'haulings_location_from' => $this->haulings_location_from,
            'haulings_location_to' => $this->haulings_location_to,
            'stalls_available_haulings' => $this->stalls_available_haulings,
            'salary' => $this->salary,
            'fixed_pay' => $this->fixed_pay,
            'hourly' => $this->hourly,
            'precise_location' => $this->precise_location,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'street' => $this->street,
            'phone' => $this->phone,
            'banner' => $this->banner,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'agree' => $this->agree,
            'relations' => [
                'job_listing_types' => $this->product->jobListingTypes,
                'services' => $this->product->services,
                'contract_types' => $this->product->contractTypes,
                'assistance_upcoming_shows' => $this->product->assistanceUpcomingShows,
            ]
        ];
    }
}
