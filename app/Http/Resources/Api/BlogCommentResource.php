<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'author' => [
                'name' => $this->author_name,
                'avatar' => $this->user ? $this->user->avatar : null,
            ],
            'created_at' => $this->created_at,
            'replies' => BlogCommentResource::collection($this->whenLoaded('replies')),
        ];
    }
}
