<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Api\Classes\Transformer;
use DamianLewis\Api\Classes\TransformerInterface;
use DamianLewis\Api\Classes\Transformers\ImageTransformer;
use DamianLewis\Portfolio\Models\Service;
use Model;

class ServicesTransformer extends Transformer implements TransformerInterface
{
    /**
     * @var bool
     */
    protected bool $includeIcon;

    /**
     * @inheritDoc
     */
    public function transform(Model $item): ?array
    {
        if (!$item instanceof Service) {
            return null;
        }

        $data = $item->only([
            'title'
        ]);

        $data = array_merge($data, [
            'text' => $item->description,
        ]);

        if ($this->includeIcon === true) {
            $imageTransformer = resolve(ImageTransformer::class);
            $data = array_add($data, 'icon', $this->transformFile($item->icon, $imageTransformer));
        }

        return $data;
    }

    /**
     * Set to true to include the icon image in the transformed data.
     *
     * @param  bool  $isIncluded
     */
    public function setIncludeIcon(bool $isIncluded): void
    {
        $this->includeIcon = $isIncluded;
    }
}