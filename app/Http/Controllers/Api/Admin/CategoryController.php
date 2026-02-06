<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Api\Admin\CategoryRequest;
use App\Http\Resources\Api\Admin\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $categories = Category::query()
            ->with(['parent'])
            ->withCount('courses')
            ->when($request->search, fn($q, $search) => $q->search($search))
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('is_active', $request->status === 'active');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created category.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return response()->json([
            'message' => 'Category created successfully',
            'category' => new CategoryResource($category)
        ], 201);
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category->load(['parent', 'children']));
    }

    /**
     * Update the specified category.
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => new CategoryResource($category)
        ]);
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category): JsonResponse
    {
        if ($category->courses()->exists() || $category->children()->exists()) {
            return response()->json([
                'message' => 'Cannot delete category with associated courses or subcategories'
            ], 422);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }

    /**
     * Get all categories for selection.
     */
    public function getAll(): JsonResponse
    {
        $categories = Category::select('id', 'name', 'parent_id')->orderBy('name')->get();
        return response()->json($categories);
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Category $category): JsonResponse
    {
        $category->update(['is_featured' => !$category->is_featured]);

        return response()->json([
            'message' => 'Featured status updated successfully',
            'category' => new CategoryResource($category)
        ]);
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Category $category): JsonResponse
    {
        $category->update(['is_active' => !$category->is_active]);

        return response()->json([
            'message' => 'Status updated successfully',
            'category' => new CategoryResource($category)
        ]);
    }
}
