<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'avatar' => $this->user->avatar,
            'avatar_url' => $this->user->avatar_url, // FULL URL
            'headline' => $this->headline,
            'bio' => $this->bio,
            'short_bio' => $this->short_bio,
            'expertise' => $this->expertise,
            'website' => $this->website,
            'linkedin' => $this->linkedin,
            'twitter' => $this->twitter,
            'facebook' => $this->facebook,
            'youtube' => $this->youtube,
            'github' => $this->github,
            'rating' => (float) $this->rating,
            'total_reviews' => $this->total_reviews,
            'total_students' => $this->total_students,
            'total_courses' => $this->total_courses,
            'commission_rate' => (float) $this->commission_rate,
            'total_earnings' => (float) $this->total_earnings,
            'pending_earnings' => (float) $this->pending_earnings,
            'status' => $this->status,
            'approved_at' => $this->approved_at,
            'certifications' => $this->certifications,
            'achievements' => $this->achievements,
            'is_featured' => (bool) $this->is_featured,
            'created_at' => $this->created_at,
        ];
    }
}
