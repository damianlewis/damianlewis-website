<?php

declare(strict_types=1);

namespace DamianLewis\Reviews\Components;

use Cms\Classes\ComponentBase;
use DamianLewis\Reviews\Models\Testimonial as TestimonialModel;
use System\Models\File;

class Testimonial extends ComponentBase
{
    /**
     * @var TestimonialModel
     */
    private $testimonial;

    public function componentDetails(): array
    {
        return [
            'name' => 'Testimonial',
            'description' => 'Get a single activetestimonial.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'testimonial' => [
                'title' => 'Testimonial',
                'type' => 'dropdown'
            ],
            'includeRating' => [
                'title' => 'Ratings',
                'type' => 'checkbox',
                'description' => 'Include the rating.',
                'default' => false
            ]
        ];
    }

    /**
     * Return the active testimonials as an array with the id as the key and name/company as the value.
     *
     * @return array
     */
    public function getTestimonialOptions(): array
    {
        return TestimonialModel::active()->get()->pluck('nameAndCompany', 'id')->all();
    }

    public function onRun(): void
    {
        $this->testimonial = TestimonialModel::where('id', $this->property('testimonial'))->first();

        $this->page['testimonialDetails'] = $this->testimonial->only(['name', 'company', 'quote', 'image']);
    }

    /**
     * Get the rating value when it's flagged as being included.
     *
     * @return int|null
     */
    public function rating(): ?int
    {
        if ($this->property('includeRating') == true) {
            return (int) $this->testimonial->rating;
        }
    }
}
