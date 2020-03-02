<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Api\Classes\Transformer;
use DamianLewis\Api\Classes\TransformerInterface;
use DamianLewis\Api\Classes\Transformers\ImageTransformer;
use DamianLewis\Portfolio\Models\Testimonial;
use Model;

class TestimonialTransformer extends Transformer implements TransformerInterface
{
    /**
     * @var bool
     */
    protected bool $includeRating = false;

    /**
     * @inheritDoc
     */
    public function transform(Model $item): ?array
    {
        if (!$item instanceof Testimonial) {
            return null;
        }

        $data = $item->only([
            'name',
            'company',
            'quote'
        ]);

        $imageTransformer = resolve(ImageTransformer::class);

        $data = array_merge($data, [
            'image' => $this->transformFile($item->image, $imageTransformer)
        ]);

        if ($this->includeRating === true) {
            $data = array_add($data, 'rating', $item->rating);
        }

        return $data;
    }

    /**
     * Set to true to include the rating in the transformed data.
     *
     * @param  bool  $isIncluded
     */
    public function setIncludeRating(bool $isIncluded): void
    {
        $this->includeRating = $isIncluded;
    }
}
