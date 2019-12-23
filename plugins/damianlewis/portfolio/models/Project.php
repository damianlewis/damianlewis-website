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

    public $table = 'damianlewis_portfolio_projects';

    public $rules = [
        'title' => 'required',
        'slug' => [
            'sometimes',
            'required',
            'unique:damianlewis_portfolio_projects',
            'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i'
        ]
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
        $status = Attribute::where([
            ['type', Attribute::PROJECT_STATUS],
            ['code', 'active']
        ])->firstOrFail();

        return $query->where('status_id', $status->id);
    }

    /**
     * Select only the featured projects.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the image used for project the list.
     *
     * @param  bool|null  $isReversed
     * @return File|null
     */
    public function getListImage(bool $isReversed = null): ?File
    {
        if ($isReversed) {
            return $this->mockup_multiple_reversed_image;
        }

        return $this->mockup_multiple_image;
    }

    /**
     * Sets a url attribute for the project page.
     *
     * @param  string  $path
     */
    public function setUrl(string $path): void
    {
        $this->attributes['url'] = url($path, $this->slug);
    }
}
