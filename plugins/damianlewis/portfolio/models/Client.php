<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;
use System\Models\File;

class Client extends Model
{
    use Nullable;
    use Sortable;
    use Validation;

    public $table = 'damianlewis_portfolio_clients';

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public $rules = [
        'name' => 'required'
    ];

    protected $nullable = [
        'logo_width',
        'logo_opacity',
        'sort_order'
    ];

    public $attachOne = [
        'logo' => File::class
    ];

    /**
     * Select only the active clients.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
