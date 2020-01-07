<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;
use System\Models\File;

class Project extends Model
{
    use Nullable;
    use Sluggable;
    use Sortable;
    use Validation;

    /**
     * The attributes on which the projects can be ordered.
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
     * The direction the projects can be ordered.
     *
     * @var array
     */
    public static $orderDirectionOptions = [
        'asc' => 'Ascending',
        'desc' => 'Descending'
    ];

    public $rules = [
        'title' => 'required',
        'slug' => [
            'sometimes',
            'required',
            'unique:damianlewis_portfolio_projects',
            'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i'
        ]
    ];

    public $hasOne = [
        'testimonial' => Testimonial::class
    ];

    public $belongsTo = [
        'status' => [
            Attribute::class,
            'conditions' => "type = '".Attribute::PROJECT_STATUS."'"
        ]
    ];

    public $belongsToMany = [
        'skills' => [
            Skill::class,
            'table' => 'damianlewis_portfolio_project_skill',
            'timestamps' => true
        ],
        'technologies' => [
            Technology::class,
            'table' => 'damianlewis_portfolio_project_technology',
            'timestamps' => true
        ]
    ];

    public $attachOne = [
        'preview_image' => File::class,
        'mockup_desktop_image' => File::class,
        'mockup_multiple_image' => File::class,
        'mockup_multiple_reversed_image' => File::class,
        'mockup_multiple_in_sequence_image' => File::class,
        'desktop_full_frame_image' => File::class,
        'tablet_full_frame_image' => File::class,
        'mobile_full_frame_image' => File::class
    ];

    public $attachMany = [
        'design_images' => File::class
    ];

    protected $table = 'damianlewis_portfolio_projects';

    protected $casts = [
        'is_featured' => 'boolean',
        'is_hidden' => 'boolean'
    ];

    protected $dates = [
        'completed_at'
    ];

    protected $slugs = [
        'slug' => 'title'
    ];

    protected $nullable = [
        'title',
        'slug',
        'tag_line',
        'summary',
        'sort_order',
        'description',
        'completed_at'
    ];

    /**
     * Select projects with an active status.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        $status = Attribute::activeProjectStatus();

        return $query->where('status_id', $status->id);
    }

    /**
     * Select featured projects.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Select visible projects.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }

    /**
     * Returns an ordered collection of projects for the frontend.
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
            ->active()
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
