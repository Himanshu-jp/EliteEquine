<?php

namespace App\Http\Resources\API\v1\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CategoryThreeProductDetailResource extends JsonResource
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
            'stalls_available' => $this->stalls_available,
            'fromdate' => $this->fromdate ? Carbon::parse($this->fromdate)->toDateString() : null,
            'todate' => $this->todate ? Carbon::parse($this->todate)->toDateString() : null,
            'sleeps' => $this->sleeps,
            'daily_board_rental_rate' => $this->daily_board_rental_rate,
            'monthly_board_rental_rate' => $this->monthly_board_rental_rate,
            'weekly_board_rental_rate' => $this->weekly_board_rental_rate,
            'sale_cost' => $this->sale_cost,
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
                'property_types' => $this->product->propertyTypes,
                'stable_amenities' => $this->product->stableAmenities,
                'housing_stables_around_horse_shows' => $this->product->housingStablesAroundHorseShows,
                'housing_amenities' => $this->product->housingAmenities,
                'realtors' => $this->product->realtors,
                'property_managers' => $this->product->propertyManagers,
            ]
        ];
    }
}
