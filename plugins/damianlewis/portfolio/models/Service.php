<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;
use System\Models\File;

class Service extends Model
{
    use Nullable;
    use Sortable;
    use Validation;

    /**
     * The attributes on which the projects can be ordered.
     *
     * @var array
     */
    public static array $orderByOptions = [
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
    public static array $orderDirectionOptions = [
        'asc' => 'Ascending',
        'desc' => 'Descending'
    ];

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    public array $rules = [
        'title' => 'required'
    ];


    public $belongsTo = [
        'category' => [
            Category::class
        ]
    ];

    public $attachOne = [
        'icon' => File::class
    ];

    protected $table = 'damianlewis_portfolio_services';

    protected $casts = [
        'is_featured' => 'boolean',
        'is_hidden' => 'boolean',
        'is_hidden_in_list' => 'boolean'
    ];

    /**
     * List of attribute names which should be set to null when empty.
     *
     * @var array
     */
    protected array $nullable = [
        'category_id',
        'title',
        'description'
    ];

    /**
     * Select featured services.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Select visible services.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }

    /**
     * Select in list services.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeInList(Builder $query): Builder
    {
        return $query->where('is_hidden_in_list', false);
    }

    /**
     * Returns an ordered collection of services for the frontend.
     *
     * @param  Builder  $query
     * @param  array  $options
     * @return Builder
     */
    public function scopeFrontEndCollection(Builder $query, array $options = []): Builder
    {
        /**
         * @var bool $featured
         * @var bool $inList
         * @var int $limit
         * @var string $orderBy
         * @var string $orderDirection
         */
        extract(array_merge([
            'featured' => false,
            'inList' => false,
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
            ->when($inList, function ($query) {
                return $query->inList();
            })
            ->when($limit > 0, function ($query) use ($limit) {
                return $query->take($limit);
            })
            ->when($sortOrderByValid && $sortOrderDirectionValid, function ($query) use ($orderBy, $orderDirection) {
                return $query->orderBy($orderBy, $orderDirection);
            });
    }
}
