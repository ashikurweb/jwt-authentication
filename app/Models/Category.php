<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasSlug;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'color',
        'is_featured',
        'is_active',
        'meta',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'meta' => 'array',
    ];

    // ========== Relationships ==========

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function subcourses(): HasMany
    {
        return $this->hasMany(Course::class, 'subcategory_id');
    }

    // ========== Scopes ==========

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    // ========== Helpers ==========

    public function getAllChildren()
    {
        return $this->children()->with('children')->get();
    }

    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }
}
