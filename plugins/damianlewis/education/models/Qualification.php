<?php

declare(strict_types=1);

namespace DamianLewis\Education\Models;

use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;

class Qualification extends Model
{
    use Nullable;
    use Sortable;
    use Validation;

    /**
     * The attributes on which the qualifications can be ordered.
     *
     * @var array
     */
    public static array $orderByOptions = [
        'sort_order' => 'Sort order',
        'created_at' => 'Created date',
        'updated_at' => 'Updated date',
        'completed_at' => 'Completed date',
        'title' => 'Title'
    ];

    /**
     * The direction the qualifications can be ordered.
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

    protected $table = 'damianlewis_education_qualifications';

    protected $casts = [
        'is_hidden' => 'boolean'
    ];

    protected $dates = [
        'completed_at'
    ];

    /**
     * List of attribute names which should be set to null when empty.
     *
     * @var array
     */
    protected array $nullable = [
        'title',
        'score',
        'sort_order',
        'completed_at'
    ];

    /**
     * Select visible qualifications.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }

    /**
     * Returns an ordered collection of qualifications for the frontend.
     *
     * @param  Builder  $query
     * @param  array  $options
     * @return Builder
     */
    public function scopeFrontEndCollection(Builder $query, array $options = []): Builder
    {
        /**
         * @var string $orderBy
         * @var string $orderDirection
         */
        extract(array_merge([
            'orderBy' => 'sort_order',
            'orderDirection' => 'asc'
        ], $options));

        $sortOrderByValid = in_array($orderBy, array_keys(self::$orderByOptions));
        $sortOrderDirectionValid = in_array($orderDirection, array_keys(self::$orderDirectionOptions));

        return $query
            ->visible()
            ->when($sortOrderByValid && $sortOrderDirectionValid, function ($query) use ($orderBy, $orderDirection) {
                return $query->orderBy($orderBy, $orderDirection);
            });
    }
}
