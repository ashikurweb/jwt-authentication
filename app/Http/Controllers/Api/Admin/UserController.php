<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Api\Admin\UserRequest;
use App\Http\Resources\Api\Admin\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of students (users with 'student' role).
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $users = User::query()
            ->withCount('student_enrollments')
            ->whereDoesntHave('roles', function($q) {
                $q->whereIn('name', ['admin', 'super-admin']);
            })
            ->when($request->search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        \Log::info('Fetched users count: ' . $users->count());
        return UserResource::collection($users);
    }

    /**
     * Store a newly created student.
     */
    public function store(UserRequest $request): JsonResponse
    {
        $avatar = $request->avatar;
        if ($avatar && str_starts_with($avatar, config('app.url'))) {
            $avatar = str_replace(config('app.url') . '/storage/', '', $avatar);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'avatar' => $avatar,
            'status' => $request->status ?? 'active',
            'email_verified_at' => now(), 
        ]);

        return response()->json([
            'message' => 'Student created successfully',
            'user' => new UserResource($user)
        ], 201);
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): UserResource
    {
        $user->loadCount('student_enrollments');
        return new UserResource($user);
    }

    /**
     * Update the specified student.
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        
        if ($request->has('password') && !empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        if ($request->has('avatar')) {
            $avatar = $request->avatar;
            if ($avatar && str_starts_with($avatar, config('app.url'))) {
                $avatar = str_replace(config('app.url') . '/storage/', '', $avatar);
            }
            $data['avatar'] = $avatar;
        }

        $user->update($data);

        return response()->json([
            'message' => 'Student updated successfully',
            'user' => new UserResource($user)
        ]);
    }

    /**
     * Remove the specified student.
     */
    public function destroy(User $user): JsonResponse
    {
        // Maybe check for enrollments before deleting?
        // if ($user->enrollments()->exists()) { ... }

        $user->delete();

        return response()->json([
            'message' => 'Student deleted successfully'
        ]);
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(User $user): JsonResponse
    {
        $newStatus = $user->status === 'active' ? 'suspended' : 'active';
        $user->update(['status' => $newStatus]);

        return response()->json([
            'message' => "Student status updated to {$newStatus}",
            'user' => new UserResource($user)
        ]);
    }
}
