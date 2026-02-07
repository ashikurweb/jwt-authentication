<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'uuid' => $this->uuid,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar_url,
            'status' => $this->status,
            'is_active' => $this->status === 'active',
            'created_at' => $this->created_at->format('M d, Y'),
            'last_login_at' => $this->last_login_at ? $this->last_login_at->format('M d, Y h:i A') : 'Never',
            'roles' => $this->getRoleNames() ?? [],
            // You can add more progress-related data here later
            'courses_count' => $this->student_enrollments_count ?? 0, 
        ];
    }
}
