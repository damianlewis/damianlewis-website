<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Client;
use DamianLewis\Transformer\Classes\CanTransform;
use DamianLewis\Transformer\Classes\Transformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use DamianLewis\Transformer\Classes\Transformers\FileTransformer;
use Model;

class ClientLogosTransformer extends Transformer implements TransformerInterface
{
    use CanTransform;

    /**
     * @inheritDoc
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Client) {
            return [];
        }

        $fileTransformer = resolve(FileTransformer::class);

        return [
            'image' => $this->transformItemOrNull($fileTransformer, $item->logo),
            'width' => $item->logo_width,
            'opacity' => $item->logo_opacity
        ];
    }
}
