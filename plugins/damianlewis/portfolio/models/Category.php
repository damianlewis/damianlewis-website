<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\SimpleTree;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Halcyon\Traits\Validation;

class Category extends Model
{
    use Nullable;
    use SimpleTree;
    use Sortable;
    use Validation;

    const CATEGORY_NAME_SKILLS = 'Skills';
    const CATEGORY_NAME_TECHNOLOGIES = 'Technologies';

    public $rules = [
        'name' => 'required'
    ];

    public $hasMany = [
        'skills' => [
            Skill::class
        ]
    ];

    protected $table = 'damianlewis_portfolio_categories';

    protected $casts = [
        'is_hidden' => 'boolean'
    ];

    protected $nullable = [
        'parent_id',
        'name',
        'sort_order'
    ];

    /**
     * Select visible categories.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }

    /**
     * Select the top level root categories.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeRoot(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }
}
