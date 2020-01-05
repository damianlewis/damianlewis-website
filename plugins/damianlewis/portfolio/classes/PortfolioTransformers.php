<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes;

use DamianLewis\Portfolio\Classes\Transformers\AttributeTransformer;
use DamianLewis\Portfolio\Classes\Transformers\TestimonialTransformer;
use DamianLewis\Portfolio\Models\Testimonial;
use Model;
use October\Rain\Database\Collection;

trait PortfolioTransformers
{
    /**
     * @var AttributeTransformer
     */
    protected AttributeTransformer $attributeTransformer;

    /**
     * @var TestimonialTransformer
     */
    protected TestimonialTransformer $testimonialTransformer;

    /**
     * Transforms the given attributes collection or returns null.
     *
     * @param  Collection  $collection
     * @return array|null
     */
    protected function transformAttributes(Collection $collection): ?array
    {
        if ($collection->count() > 0) {
            return $this->attributeTransformer->transformCollection($collection);
        }

        return null;
    }

    /**
     * Transforms the given testimonial model or returns null.
     *
     * @param  Model|null  $model
     * @return array|null
     */
    protected function transformTestimonial(?Model $model): ?array
    {
        if ($model instanceof Testimonial) {
            return $this->testimonialTransformer->transformItem($model);
        }

        return null;
    }
}
