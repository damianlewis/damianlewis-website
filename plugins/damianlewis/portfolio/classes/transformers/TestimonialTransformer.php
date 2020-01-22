<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Testimonial;
use DamianLewis\Transformer\Classes\CanTransform;
use DamianLewis\Transformer\Classes\Transformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use DamianLewis\Transformer\Classes\Transformers\FileTransformer;
use Model;

class TestimonialTransformer extends Transformer implements TransformerInterface
{
    use CanTransform;

    /**
     * @var bool
     */
    protected bool $includeRating = false;

    /**
     * @inheritDoc
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Testimonial) {
            return [];
        }

        $data = $item->only([
            'name',
            'company',
            'quote'
        ]);

        $fileTransformer = resolve(FileTransformer::class);

        $data = array_merge($data, [
            'image' => $this->transformItemOrNull($fileTransformer, $item->image)
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
