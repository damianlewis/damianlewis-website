<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Testimonial;
use Model;

class TestimonialTransformer implements TransformerInterface
{
    /**
     * @var bool
     */
    protected $includeRating;

    /**
     * @inheritDoc
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Testimonial) {
            return [];
        }

        $fileTransformer = resolve(FileTransformer::class);

        $data = $item->only([
            'name',
            'company',
            'quote'
        ]);

        $data = array_merge($data, [
            'image' => $fileTransformer->transformItem($item->image)
        ]);

        if ($this->includeRating === true) {
            $data = array_add($data, 'rating', $item->rating);
        }

        return $data;
    }

    public function setIncludeRating(bool $isIncluded): void
    {
        $this->includeRating = $isIncluded;
    }
}
