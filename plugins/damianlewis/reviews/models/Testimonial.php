<?php

declare(strict_types=1);

namespace DamianLewis\Reviews\Models;

use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\Validation;
use System\Models\File;

class Testimonial extends Model
{
    use Nullable;
    use Validation;

    public $table = 'damianlewis_reviews_testimonials';

    public $rules = [
        'name' => 'required',
        'quote' => 'required',
        'rating' => 'integer|nullable|min:1|max:5'
    ];

    public $attachOne = [
        'image' => File::class
    ];

    protected $casts = [
        'is_active' => 'boolean'
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
     * Select only the active testimonials.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
