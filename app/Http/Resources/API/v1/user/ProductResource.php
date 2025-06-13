<?php

namespace App\Http\Resources\API\v1\user;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\API\v1\user\CategoryOneProductDetailResource;
use App\Http\Resources\API\v1\user\CategoryTwoProductDetailResource;
use App\Http\Resources\API\v1\user\CategoryThreeProductDetailResource;
use App\Http\Resources\API\v1\user\CategoryFourProductDetailResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        $productDetailResource = null;

        switch ($this->category_id) {
            case 1:
                $productDetailResource = new CategoryOneProductDetailResource($this->productDetail);
                break;
            case 2:
                $productDetailResource = new CategoryTwoProductDetailResource($this->productDetail);
                break;
            case 3:
                $productDetailResource = new CategoryThreeProductDetailResource($this->productDetail);
                break;
            case 4:
                $productDetailResource = new CategoryFourProductDetailResource($this->productDetail);
                break;
        }

        $user = Auth::guard('sanctum')->user();
        $isFavorited = false;

        if ($user) {
            $isFavorited = $this->favorites()
                ->where('user_id', $user->id)
                ->exists();
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'sale_method' => $this->sale_method,
            'title' => $this->title,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->sub_category,
            'price' => $this->price,
            'is_negotiable' => $this->is_negotiable,
            'currency' => $this->currency,
            'description' => $this->description,
            'external_link' => $this->external_link,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'images' => $this->image ? $this->image->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => asset('storage/' . $image->image)
                ];
            }) : [], // Check if images exist, otherwise return empty array
            'videos' => $this->video ? $this->video->map(function ($video) {
                return [
                    'id' => $video->id,
                    'url' => asset('storage/' . $video->video_url),
                    'thumbnail' => asset('storage/' . $video->thumbnail)
                ];
            }) : [], // Check if videos exist, otherwise return empty array
            'documents' => $this->document ? $this->document->map(function ($document) {
                return [
                    'id' => $document->id,
                    'url' => asset('storage/' . $document->file)
                ];
            }) : [], // Check if documents exist, otherwise return empty array
            'product_details' => $productDetailResource,
            'is_favorited' => $isFavorited,
        ];
    }
}
