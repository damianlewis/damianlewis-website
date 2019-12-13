<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;
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

    protected $dates = [
        'created_at',
        'updated_at',
        'completed_at'
    ];

    /**
     * List of attributes to generate unique slugs for.
     *
     * @var array
     */
    protected $slugs = [
        'slug' => 'title',
    ];

    protected $nullable = [
        'tag_line',
        'summary',
        'description',
        'completed_at'
    ];

    public $rules = [
        'title' => 'required',
        'slug' => [
            'sometimes',
            'required',
            'unique:damianlewis_portfolio_projects',
            'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i'
        ],
        'preview_image' => 'nullable|mimes:jpeg|dimensions:ratio=4/3',
        'mockup_desktop_image' => 'nullable|mimes:jpeg,png|dimensions:min_width=594',
        'mockup_multiple_image' => 'nullable|mimes:jpeg,png|dimensions:min_width=546',
        'mockup_multiple_reversed_image' => 'nullable|mimes:jpeg,png|dimensions:min_width=546',
        'mockup_multiple_in_sequence_image' => 'nullable|mimes:jpeg,png|dimensions:min_width=1140',
        'desktop_full_frame_image' => 'nullable|mimes:jpeg,png|dimensions:min_width=1140',
        'tablet_full_frame_image' => 'nullable|mimes:jpeg,png|dimensions:min_width=696',
        'mobile_full_frame_image' => 'nullable|mimes:jpeg,png|dimensions:min_width=272',
        'design_images' => 'nullable|mimes:jpeg,png|dimensions:ratio=4/3'
    ];

    protected $casts = [
        'is_featured' => 'boolean'
    ];

    public $belongsTo = [
        'status' => [
            Attribute::class,
            'conditions' => "type = 'project.status'"
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
}
