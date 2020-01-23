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

    /**
     * The attributes on which the client list can be ordered.
     *
     * @var array
     */
    public static $orderByOptions = [
        'sort_order' => 'Sort order',
        'created_at' => 'Created date',
        'updated_at' => 'Updated date',
        'name' => 'Name'
    ];

    /**
     * The direction the client list can be ordered.
     *
     * @var array
     */
    public static $orderDirectionOptions = [
        'asc' => 'Ascending',
        'desc' => 'Descending'
    ];

    public $rules = [
        'name' => 'required'
    ];

    public $attachOne = [
        'logo' => File::class
    ];

    protected $table = 'damianlewis_portfolio_clients';

    protected $casts = [
        'is_hidden' => 'boolean'
    ];

    protected $nullable = [
        'name',
        'logo_width',
        'logo_opacity'
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
     * Returns an ordered collection of clients for the frontend.
     *
     * @param  Builder  $query
     * @param  array  $options
     * @return Builder
     */
    public function scopeFrontEndCollection(Builder $query, array $options = []): Builder
    {
        /**
         * @var int $limit
         * @var string $orderBy
         * @var string $orderDirection
         */
        extract(array_merge([
            'limit' => null,
            'orderBy' => 'sort_order',
            'orderDirection' => 'asc'
        ], $options));

        $sortOrderByValid = in_array($orderBy, array_keys(self::$orderByOptions));
        $sortOrderDirectionValid = in_array($orderDirection, array_keys(self::$orderDirectionOptions));

        return $query
            ->visible()
            ->when($limit > 0, function ($query) use ($limit) {
                return $query->take($limit);
            })
            ->when($sortOrderByValid && $sortOrderDirectionValid, function ($query) use ($orderBy, $orderDirection) {
                return $query->orderBy($orderBy, $orderDirection);
            });
    }
}
