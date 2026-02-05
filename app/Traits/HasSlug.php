<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait and register the saving event.
     */
    protected static function bootHasSlug()
    {
        static::saving(function ($model) {
            $sourceField = $model->slugSourceField() ?? 'name';
            $slugField = $model->slugTargetField() ?? 'slug';

            if (empty($model->{$slugField}) || $model->isDirty($sourceField)) {
                $slug = Str::slug($model->{$sourceField});
                
                // Ensure uniqueness
                $originalSlug = $slug;
                $count = 1;
                
                while (static::where($slugField, $slug)
                    ->where($model->getKeyName(), '!=', $model->getKey())
                    ->exists()
                ) {
                    $slug = "{$originalSlug}-" . $count++;
                }

                $model->{$slugField} = $slug;
            }
        });
    }

    /**
     * Get the attribute name to generate the slug from.
     * Can be overridden in the model.
     */
    public function slugSourceField(): string
    {
        return 'name';
    }

    /**
     * Get the attribute name to store the slug in.
     * Can be overridden in the model.
     */
    public function slugTargetField(): string
    {
        return 'slug';
    }
}
