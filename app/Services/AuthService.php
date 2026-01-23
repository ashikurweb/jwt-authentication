<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthService
{
    /**
     * Register a new user
     */
    public function register(array $data)
    {
        // Hash Password
        $data['password'] = Hash::make($data['password']);

        // Set default status if not provided
        $data['status'] = $data['status'] ?? 'active';

        // Create User
        $user = User::create($data);

        // Assign Default Role (Spatie)
        $user->assignRole('user');

        return $user;
    }

    public function login(array $credentials)
    {
        $identity = $credentials['identity'];
        $password = $credentials['password'];

        // Check if identity is email, phone or username
        $fieldType = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 
                    (preg_match('/^\+?\d+$/', $identity) ? 'phone' : 'username');

        if (!$token = auth('api')->attempt([$fieldType => $identity, 'password' => $password])) {
            return null;
        }

        return $token;
    }

    /**
     * Generate JWT Token for user
     */
    public function generateToken($user)
    {
        return auth('api')->login($user);
    }
}
