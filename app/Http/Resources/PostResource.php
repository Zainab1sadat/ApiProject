<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'image' => $this->image,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'description' => $this->description,
            'price' => $this->price,
            'created' => $this->created_at->diffForHumans(),
            'user'=>UserResource::make($this->user)
        ];
    }
}
