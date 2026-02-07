<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstructorProfile;
use App\Http\Requests\Api\Admin\InstructorProfileRequest;
use App\Http\Resources\Api\Admin\InstructorResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InstructorController extends Controller
{
    /**
     * Display a listing of the instructors.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $instructors = InstructorProfile::query()
            ->with(['user'])
            ->withCount('courses')
            ->when($request->search, fn($q, $search) => $q->search($search))
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return InstructorResource::collection($instructors);
    }

    /**
     * Store a newly created instructor.
     */
    public function store(InstructorProfileRequest $request): JsonResponse
    {
        $avatar = $request->avatar;
        if ($avatar && str_starts_with($avatar, config('app.url'))) {
            $avatar = str_replace(config('app.url') . '/storage/', '', $avatar);
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'avatar' => $avatar,
            'username' => \Illuminate\Support\Str::slug($request->name) . '-' . rand(1000, 9999),
            'status' => 'active',
        ];

        $user = \App\Models\User::create($userData);
        $user->assignRole('instructor'); 

        $profileData = $request->except(['name', 'email', 'phone', 'password', 'avatar']);
        $profileData['user_id'] = $user->id;
        
        if ($request->status === 'approved') {
            $profileData['approved_at'] = now();
        }

        $instructor = InstructorProfile::create($profileData);

        return response()->json([
            'message' => 'Instructor created successfully',
            'instructor' => new InstructorResource($instructor->load('user'))
        ], 201);
    }

    /**
     * Display the specified instructor.
     */
    public function show(InstructorProfile $instructor): InstructorResource
    {
        return new InstructorResource($instructor->load(['user']));
    }

    /**
     * Update the specified instructor.
     */
    public function update(InstructorProfileRequest $request, InstructorProfile $instructor): JsonResponse
    {
        // Update user data if provided
        $userFields = $request->only(['name', 'email', 'phone']);
        
        if ($request->has('avatar')) {
            $avatar = $request->avatar;
            if ($avatar && str_starts_with($avatar, config('app.url'))) {
                $avatar = str_replace(config('app.url') . '/storage/', '', $avatar);
            }
            $userFields['avatar'] = $avatar;
        }

        if (!empty($userFields)) {
            $instructor->user->update($userFields);
        }

        $instructor->update($request->validated());

        if ($request->status === 'approved' && !$instructor->approved_at) {
            $instructor->update(['approved_at' => now()]);
        }

        return response()->json([
            'message' => 'Instructor profile updated successfully',
            'instructor' => new InstructorResource($instructor->load('user'))
        ]);
    }

    /**
     * Remove the specified instructor.
     */
    public function destroy(InstructorProfile $instructor): JsonResponse
    {
        // Maybe check if they have courses?
        if ($instructor->courses()->exists()) {
             return response()->json([
                'message' => 'Cannot delete instructor with associated courses'
            ], 422);
        }

        $instructor->delete();

        return response()->json([
            'message' => 'Instructor deleted successfully'
        ]);
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(InstructorProfile $instructor): JsonResponse
    {
        $instructor->update(['is_featured' => !$instructor->is_featured]);

        return response()->json([
            'message' => 'Featured status updated successfully',
            'instructor' => new InstructorResource($instructor)
        ]);
    }

    /**
     * Toggle status (approved/suspended).
     */
    public function toggleStatus(InstructorProfile $instructor): JsonResponse
    {
        $newStatus = $instructor->status === 'approved' ? 'suspended' : 'approved';
        
        $data = ['status' => $newStatus];
        if ($newStatus === 'approved' && !$instructor->approved_at) {
            $data['approved_at'] = now();
        }

        $instructor->update($data);

        return response()->json([
            'message' => "Instructor status updated to {$newStatus}",
            'instructor' => new InstructorResource($instructor)
        ]);
    }
}
