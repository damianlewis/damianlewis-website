<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Api\Classes\Transformer;
use DamianLewis\Api\Classes\TransformerInterface;
use DamianLewis\Api\Classes\Transformers\ImageTransformer;
use DamianLewis\Portfolio\Models\Client;
use Model;

class ClientLogosTransformer extends Transformer implements TransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform(Model $item): ?array
    {
        if (!$item instanceof Client) {
            return null;
        }

        $imageTransformer = resolve(ImageTransformer::class);

        return [
            'image' => $this->transformFile($item->logo, $imageTransformer),
            'width' => $item->logo_width,
            'opacity' => $item->logo_opacity
        ];
    }
}
