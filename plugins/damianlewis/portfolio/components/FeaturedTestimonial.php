<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use DamianLewis\Portfolio\Classes\Transformers\TestimonialTransformer;
use DamianLewis\Portfolio\Models\Testimonial;
use DamianLewis\Transformer\Components\TransformerComponent;

class FeaturedTestimonial extends TransformerComponent
{
    /**
     * @var TestimonialTransformer
     */
    protected $transformer;

    public function componentDetails(): array
    {
        return [
            'name' => 'Testimonial',
            'description' => 'Select a testimonial to be featured.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'includeRating' => [
                'title' => 'Ratings',
                'type' => 'checkbox',
                'description' => 'Include the rating.',
                'default' => false
            ]
        ];
    }

    public function init(): void
    {
        $this->transformer = resolve(TestimonialTransformer::class);
    }

    public function onRun(): void
    {
        $testimonial = $this->getFirstFeaturedTestimonial();

        if ($testimonial !== null) {
            $this->transformer->setIncludeRating($this->property('includeRating') == true);
            $this->page['testimonial'] = $this->transformItem($testimonial);
        }
    }

    /**
     * Returns an array of active testimonials with the id as the key and name/company as the value.
     *
     * @return array
     */
    public function getIdOptions(): array
    {
        $testimonials = Testimonial::active()->get();

        return $testimonials->pluck('nameAndCompany', 'id')->all();
    }

    /**
     * Returns the first featured testimonial from the database.
     *
     * @return Testimonial|null
     */
    protected function getFirstFeaturedTestimonial(): ?Testimonial
    {
        return Testimonial::featured()
            ->visible()
            ->first();
    }
}
