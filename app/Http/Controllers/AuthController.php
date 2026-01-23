<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponse;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * User Registration
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->register($request->validated());

            $token = $this->authService->generateToken($user);

            return $this->successResponse([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ], 'User registered successfully', 201);

        } catch (Exception $e) {
            return $this->errorResponse('Registration failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * User Login
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->authService->login($request->validated());

            if (!$token) {
                return $this->errorResponse('Invalid credentials', 401);
            }

            return $this->successResponse([
                'user' => auth('api')->user(),
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ], 'Login successful');

        } catch (Exception $e) {
            return $this->errorResponse('Login failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get authenticated user profile
     */
    public function me(): JsonResponse
    {
        return $this->successResponse(auth('api')->user(), 'User profile fetched successfully');
    }

    /**
     * Logout user
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();
        return $this->successResponse(null, 'Successfully logged out');
    }
}
