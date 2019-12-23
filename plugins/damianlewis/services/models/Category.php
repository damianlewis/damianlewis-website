<?php

declare(strict_types=1);

namespace DamianLewis\Services\Models;

use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;
use System\Models\File;

class Category extends Model
{
    use Nullable;
    use Sluggable;
    use Sortable;
    use Validation;

    /**
     * The attributes on which the category list can be ordered.
     *
     * @var array
     */
    public static $orderByOptions = [
        'sort_order' => 'Sort order',
        'created_at' => 'Created date',
        'updated_at' => 'Updated date',
        'title' => 'Title'
    ];

    /**
     * The direction the category list can be ordered.
     *
     * @var array
     */
    public static $orderDirectionOptions = [
        'asc' => 'Ascending',
        'desc' => 'Descending'
    ];

    public $table = 'damianlewis_services_categories';

    public $rules = [
        'title' => 'required',
        'slug' => [
            'sometimes',
            'required',
            'unique:damianlewis_services_categories',
            'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i'
        ]
    ];

    public $attachOne = [
        'preview_image' => File::class,
        'hero_image' => File::class,
        'list_image' => File::class,
        'featured_icon' => File::class
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_visible' => 'boolean'
    ];

    protected $slugs = [
        'slug' => 'title'
    ];

    protected $nullable = [
        'title',
        'slug',
        'featured_text',
        'hero_text',
        'list_text',
        'description',
        'sort_order'
    ];

    /**
     * Select only the featured categories.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Select only the visible categories.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }

    /**
     * Returns an ordered collection of categories for the frontend.
     *
     * @param  Builder  $query
     * @param  array  $options
     * @return Builder
     */
    public function scopeFrontEndCollection(Builder $query, array $options = []): Builder
    {
        /**
         * @var bool $featured
         * @var int $limit
         * @var string $orderBy
         * @var string $orderDirection
         */
        extract(array_merge([
            'featured' => false,
            'limit' => null,
            'orderBy' => 'sort_order',
            'orderDirection' => 'asc'
        ], $options));

        $sortOrderByValid = in_array($orderBy, array_keys(self::$orderByOptions));
        $sortOrderDirectionValid = in_array($orderDirection, array_keys(self::$orderDirectionOptions));

        return $query
            ->visible()
            ->when($featured, function ($query) {
                return $query->featured();
            })
            ->when($limit > 0, function ($query) use ($limit) {
                return $query->take($limit);
            })
            ->when($sortOrderByValid && $sortOrderDirectionValid, function ($query) use ($orderBy, $orderDirection) {
                return $query->orderBy($orderBy, $orderDirection);
            });
    }
}
