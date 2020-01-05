<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use Cms\Classes\ComponentBase;
use DamianLewis\Portfolio\Classes\Transformers\TestimonialTransformer;
use DamianLewis\Portfolio\Models\Testimonial as TestimonialModel;

class Testimonial extends ComponentBase
{
    /**
     * @var TestimonialTransformer
     */
    protected TestimonialTransformer $transformer;

    /**
     * @var array|null
     */
    protected ?array $transformedTestimonial = null;

    public function componentDetails(): array
    {
        return [
            'name' => 'Testimonial',
            'description' => 'Get an active testimonial.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'id' => [
                'title' => 'Testimonial',
                'type' => 'dropdown',
                'description' => 'The testimonial to display',
                'placeholder' => 'Select a testimonial'
            ],
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
        $id = (int) $this->property('id');
        $testimonial = $this->getTestimonialById($id);

        $this->transformer->setIncludeRating($this->property('includeRating') == true);
        $this->page['testimonial'] = $this->transformTestimonial($testimonial);
    }

    /**
     * Returns an array of active testimonials with the id as the key and name/company as the value.
     *
     * @return array
     */
    public function getIdOptions(): array
    {
        $testimonials = TestimonialModel::active()->get();

        return $testimonials->pluck('nameAndCompany', 'id')->all();
    }

    /**
     * Returns a testimonial from the database with the given id.
     *
     * @param  int  $id
     * @return TestimonialModel|null
     */
    protected function getTestimonialById(int $id): ?TestimonialModel
    {
        return TestimonialModel::query()
            ->active()
            ->visible()
            ->where('id', $id)
            ->first();
    }

    /**
     * Returns the transformed testimonial.
     *
     * @param  TestimonialModel|null  $testimonial
     * @return array|null
     */
    protected function transformTestimonial(?TestimonialModel $testimonial): ?array
    {
        if ($this->transformedTestimonial !== null) {
            return $this->transformedTestimonial;
        }

        if ($testimonial !== null) {
            return $this->transformedTestimonial = $this->transformer->transformItem($testimonial);
        }

        return null;
    }
}
