<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Classes\Transformers;

use DamianLewis\Api\Classes\Transformer;
use DamianLewis\Api\Classes\TransformerInterface;
use DamianLewis\Api\Classes\Transformers\ImageTransformer;
use DamianLewis\Pages\Models\Hero;
use Model;

class HeroTransformer extends Transformer implements TransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform(Model $item): ?array
    {
        if (!$item instanceof Hero) {
            return null;
        }

        $data = $item->only([
            'header',
            'body'
        ]);

        $imageTransformer = resolve(ImageTransformer::class);

        $data = array_merge($data, [
            'image' => $this->transformFile($item->image, $imageTransformer),
            'bgTablet' => $this->transformFile($item->background_image_tablet, $imageTransformer),
            'bgMobile' => $this->transformFile($item->background_image_mobile, $imageTransformer),
        ]);

        return $data;
    }
}
