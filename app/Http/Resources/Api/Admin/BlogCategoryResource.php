<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
            'parent' => new BlogCategoryResource($this->whenLoaded('parent')),
            'is_active' => (bool) $this->is_active,
            'is_featured' => (bool) $this->is_featured,
            'color' => $this->color,
            'icon' => $this->icon,
            'posts_count' => $this->posts_count,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
