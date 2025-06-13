<?php

namespace App\Http\Resources\API\v1\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CategoryOneProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'age' => $this->age,
            'height_id' => $this->height_id,
            'sex_id' => $this->sex_id,
            'green_eligibilitie_id' => $this->green_eligibilitie_id,
            'fromdate' => $this->fromdate,
            'todate' => $this->todate,
            'sale_price' => $this->sale_price,
            'lease_price' => $this->lease_price,
            'trainer' => $this->trainer,
            'facility' => $this->facility,
            'sirebloodline' => $this->sirebloodline,
            'dambloodline' => $this->dambloodline,
            'usef' => $this->usef,
            'pedigree_chart' => $this->pedigree_chart,
            'phone' => $this->phone,
            'precise_location' => $this->precise_location,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'street' => $this->street,
            'banner' => $this->banner,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'agree' => $this->agree,
            'relations' => [
                'disciplines' => $this->product->disciplines,
                'breeds' => $this->product->breeds,
                'colors' => $this->product->colors,
                'training_show_experiences' => $this->product->trainingShowExperiences,
                'qualifies' => $this->product->qualifies,
                'current_fence_height' => $this->product->currentFenceHeight,
                'potential_fence_height' => $this->product->potentialFenceHeight,
                'tried_upcoming_shows' => $this->product->triedUpcomingShows,
            ]
        ];
    }
}
