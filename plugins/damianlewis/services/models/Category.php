<?php

declare(strict_types=1);

namespace DamianLewis\Services\Models;

use Cms\Classes\Controller;
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

    public $table = 'damianlewis_services_categories';

    protected $casts = [
        'is_featured' => 'boolean'
    ];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    protected $nullable = [
        'featured_text',
        'hero_text',
        'list_text',
        'description',
        'sort_order'
    ];

    protected $slugs = [
        'slug' => 'title'
    ];

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
     * Sets a url attribute for the category page.
     *
     * @param  string  $pageName
     * @param  Controller  $controller
     */
    public function setUrl(string $pageName, Controller $controller)
    {
        $params = [
            'slug' => $this->slug,
        ];

        $this->attributes['url'] = $controller->pageUrl($pageName, $params);
    }
}
