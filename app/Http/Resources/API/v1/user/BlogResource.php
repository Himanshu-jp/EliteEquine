<?php

namespace App\Http\Resources\API\v1\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'image'    => $this->image ? asset('storage/' . $this->image) : asset('/images/default-blog.png'),
            'title'    => $this->title,
            'slug'     => $this->slug,
            'category' => $this->category->name ?? null,
            'content' => $this->content,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
