<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Classes\Transformers;

use DamianLewis\Pages\Models\Hero;
use DamianLewis\Transformer\Classes\CanTransform;
use DamianLewis\Transformer\Classes\TransformerInterface;
use DamianLewis\Transformer\Classes\Transformers\FileTransformer;
use Model;

class HeroTransformer implements TransformerInterface
{
    use CanTransform;

    /**
     * @inheritDoc
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Hero) {
            return [];
        }

        $data = $item->only([
            'header',
            'body'
        ]);

        $fileTransformer = resolve(FileTransformer::class);

        $data = array_merge($data, [
            'image' => $this->transformItemOrNull($fileTransformer, $item->image),
            'bgTablet' => $this->transformItemOrNull($fileTransformer, $item->background_image_tablet),
            'bgMobile' => $this->transformItemOrNull($fileTransformer, $item->background_image_mobile)
        ]);

        return $data;
    }
}
