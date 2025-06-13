<?php

namespace App\Http\Resources\API\v1\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTwoProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sale_price' => $this->sale_price,
            'hourly_rental_price' => $this->hourly_rental_price,
            'fixed_rental_price' => $this->fixed_rental_price,

            // Address & Contact (if applicable)
            'phone' => $this->phone,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'street' => $this->street,
            'precise_location' => $this->precise_location,

            'banner' => $this->banner,
            'agree' => $this->agree,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'relations' => [
                'horse_apparels' => $this->product->horseApparels,
                'rider_apparels' => $this->product->riderApparels,
                'horse_tacks' => $this->product->horseTacks,
                'trailer_trucks' => $this->product->trailerTrucks,
                'for_barns' => $this->product->forBarns,
                'equine_supplements' => $this->product->equineSupplements,
                'conditions' => $this->product->conditions,
                'brands' => $this->product->brands,
                'horse_sizes' => $this->product->horseSizes,
                'rider_sizes' => $this->product->riderSizes,
                'exchanged_upcoming_horse_shows' => $this->product->exchangedUpcomingHorseShows,
            ],

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
