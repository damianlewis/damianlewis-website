<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Testimonial;
use DamianLewis\Transformer\Classes\FileTransformer;
use Model;
use October\Rain\Database\Collection;
use System\Models\File;

trait Transformers
{
    /**
     * @var FileTransformer
     */
    protected FileTransformer $fileTransformer;

    /**
     * @var AttributeTransformer
     */
    protected AttributeTransformer $attributeTransformer;

    /**
     * @var TestimonialTransformer
     */
    protected TestimonialTransformer $testimonialTransformer;

    /**
     * Transforms the given file model or returns null.
     *
     * @param  Model|null  $model
     * @return array|null
     */
    protected function transformFile(?Model $model): ?array
    {
        if ($model instanceof File) {
            return $this->fileTransformer->transformItem($model);
        }

        return null;
    }

    /**
     * Transforms the given file collection or returns null.
     *
     * @param  Collection  $collection
     * @return array|null
     */
    protected function transformFiles(Collection $collection): ?array
    {
        if ($collection->count() > 0) {
            return $this->fileTransformer->transformCollection($collection);
        }

        return null;
    }

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
