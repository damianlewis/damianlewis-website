<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Models;

use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\Validation;
use System\Models\File;

class Hero extends Model
{
    use Nullable;
    use Validation;

    public $table = 'damianlewis_pages_heroes';

    public $rules = [
        'description' => 'required'
    ];

    public $attachOne = [
        'image' => File::class,
        'background_image_tablet' => File::class,
        'background_image_mobile' => File::class
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $nullable = [
        'description',
        'header',
        'body'
    ];

    /**
     * Select only the active links.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
