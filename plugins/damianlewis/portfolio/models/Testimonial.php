<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\Validation;
use System\Models\File;

class Testimonial extends Model
{
    use Nullable;
    use Validation;

    public $rules = [
        'name' => 'required',
        'quote' => 'required',
        'rating' => 'integer|nullable|min:1|max:5'
    ];

    public $belongsTo = [
        'project' => Project::class
    ];

    public $attachOne = [
        'image' => File::class
    ];

    protected $table = 'damianlewis_portfolio_testimonials';

    protected $casts = [
        'is_featured' => 'boolean',
        'is_hidden' => 'boolean'
    ];

    protected $nullable = [
        'name',
        'company',
        'quote',
        'rating'
    ];

    /**
     * Return formatted string of both name and company (if available).
     *
     * @return string
     */
    public function getNameAndCompanyAttribute(): string
    {
        $nameAndCompany = $this->name;
        $nameAndCompany .= $this->company ? ' - '.$this->company : '';

        return $nameAndCompany;
    }

    /**
     * Select featured testimonials.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Select visible testimonials.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }
}
