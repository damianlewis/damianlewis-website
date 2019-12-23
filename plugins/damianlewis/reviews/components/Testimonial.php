<?php

declare(strict_types=1);

namespace DamianLewis\Reviews\Components;

use Cms\Classes\ComponentBase;
use DamianLewis\Reviews\Models\Testimonial as TestimonialModel;

class Testimonial extends ComponentBase
{
    /**
     * @var TestimonialModel|null
     */
    private $testimonial;

    public function componentDetails(): array
    {
        return [
            'name' => 'Testimonial',
            'description' => 'Get a single active testimonial.'
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
     * Returns an array of active testimonials with the id as the key and name/company as the value.
     *
     * @return array
     */
    public function getTestimonialOptions(): array
    {
        $activeTestimonials = TestimonialModel::active()->get();

        return $activeTestimonials->pluck('nameAndCompany', 'id')->all();
    }

    public function onRun(): void
    {
        $id = (int) $this->property('testimonial');

        $this->testimonial = $this->getActiveTestimonialById($id);
    }

    /**
     * Returns a transformed testimonial model for consumption by the frontend.
     *
     * @return array The transformed model data.
     */
    public function item(): array
    {
        if (!$this->isAvailable()) {
            return [];
        }

        return $this->transformTestimonial($this->testimonial);
    }

    /**
     * Returns true is a testimonial model has been set for the component.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return !!$this->testimonial;
    }

    /**
     * Transforms a testimonial model into the data required by the frontend.
     *
     * @param  TestimonialModel  $testimonial
     * @return array The transformed model data.
     */
    protected function transformTestimonial(TestimonialModel $testimonial): array
    {
        $data = $testimonial->only([
            'name',
            'company',
            'quote',
            'image'
        ]);

        if ($this->property('includeRating') == true) {
            $data = array_add($data, 'rating', $testimonial->rating);
        }

        return $data;
    }

    /**
     * Returns the active testimonial model with the given id.
     *
     * @param  int  $id
     * @return TestimonialModel|null
     */
    protected function getActiveTestimonialById(int $id): ?TestimonialModel
    {
        return TestimonialModel::active()->where('id', $id)->first();
    }
}
