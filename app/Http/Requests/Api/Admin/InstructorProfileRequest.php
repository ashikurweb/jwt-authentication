<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InstructorProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'headline' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'short_bio' => 'nullable|string|max:500',
            'expertise' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'github' => 'nullable|url|max:255',
            'avatar' => 'nullable|string|max:500',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:pending,approved,rejected,suspended',
            'is_featured' => 'boolean',
            'certifications' => 'nullable|array',
            'achievements' => 'nullable|array',
        ];

        if ($this->isMethod('post')) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|unique:users,email';
            $rules['phone'] = 'nullable|string|max:20|unique:users,phone';
            $rules['password'] = 'required|string|min:8';
        }

        return $rules;
    }
}
