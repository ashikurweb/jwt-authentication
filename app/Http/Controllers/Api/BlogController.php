<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Http\Resources\Api\Admin\BlogPostResource;
use App\Http\Resources\Api\Admin\BlogCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogController extends Controller
{
    /**
     * Display a listing of published blog posts.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $posts = BlogPost::query()
            ->with(['author', 'category', 'tags'])
            ->published()
            ->when($request->search, fn($q, $search) => $q->search($search))
            ->when($request->category, fn($q, $slug) => $q->whereHas('category', fn($cq) => $cq->where('slug', $slug)))
            ->orderBy('is_pinned', 'desc')
            ->orderBy('published_at', 'desc')
            ->paginate($request->per_page ?? 12);

        return BlogPostResource::collection($posts);
    }

    /**
     * Display the specified published blog post.
     */
    public function show($slug)
    {
        $post = BlogPost::query()
            ->with(['author', 'category', 'tags', 'comments' => function($q) {
                $q->where('status', 'approved')->whereNull('parent_id')
                  ->with(['user', 'replies' => function($cq) {
                      $cq->where('status', 'approved')->with('user');
                  }]);
            }])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $post->incrementViews();

        return new BlogPostResource($post);
    }

    /**
     * Get all active categories for the sidebar.
     */
    public function categories()
    {
        $categories = BlogCategory::query()
            ->where('is_active', true)
            ->withCount('posts')
            ->orderBy('name')
            ->get();

        return BlogCategoryResource::collection($categories);
    }

    /**
     * Get featured posts.
     */
    public function featured()
    {
        $posts = BlogPost::query()
            ->with(['author', 'category'])
            ->published()
            ->featured()
            ->limit(5)
            ->get();

        return BlogPostResource::collection($posts);
    }

    /**
     * Toggle like on a post.
     */
    public function like(Request $request, $slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();
        $user = auth()->user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->detach($user->id);
            $post->decrement('likes_count');
            $liked = false;
        } else {
            $post->likes()->attach($user->id);
            $post->increment('likes_count');
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes_count
        ]);
    }

    /**
     * Post a comment on a blog post.
     */
    public function comment(Request $request, $slug)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:blog_comments,id'
        ]);

        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();
        
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'content' => $request->content,
            'status' => 'approved', // Auto-approve for now, or use pending based on settings
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $post->increment('comments_count');

        return response()->json([
            'message' => 'Comment posted successfully',
            'data' => $comment
        ], 201);
    }

    /**
     * Increment share count.
     */
    public function share($slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();
        $post->increment('shares_count');

        return response()->json([
            'shares_count' => $post->shares_count
        ]);
    }
}
