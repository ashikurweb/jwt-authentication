<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user') ? $this->route('user')->id : null;

        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $userId,
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => $userId ? 'nullable|min:8' : 'required|min:8',
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|in:active,inactive,suspended,blocked,pending',
            'avatar' => 'nullable|string',
        ];
    }
}
