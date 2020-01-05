<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Testimonial;
use DamianLewis\Shared\Classes\CommonTransformers;
use DamianLewis\Transformer\Classes\FileTransformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use Model;

class TestimonialTransformer implements TransformerInterface
{
    use CommonTransformers;

    /**
     * @var bool
     */
    protected bool $includeRating = false;

    public function __construct()
    {
        $this->fileTransformer = resolve(FileTransformer::class);
    }

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

        $data = array_merge($data, [
            'image' => $this->transformFile($item->image)
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
