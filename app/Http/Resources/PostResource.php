<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource{

    public function toArray(Request $request): array{
        return [
            'id' => $this->id,
            'body' => $this->body,
            'title' => $this->title,
            'is_pinned' => $this->is_pinned,
            'created_at' => $this->created_at,
            'cover_image' => asset("storage/uploaded/posts/" . $this->cover_image),
            'tags' => TagResource::collection($this->whenLoaded('tags'))
        ];
    }
}