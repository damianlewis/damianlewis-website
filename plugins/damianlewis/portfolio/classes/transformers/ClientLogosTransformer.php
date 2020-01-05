<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Client;
use DamianLewis\Shared\Classes\CommonTransformers;
use DamianLewis\Transformer\Classes\FileTransformer;
use DamianLewis\Transformer\Classes\Transformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use Model;

class ClientLogosTransformer extends Transformer implements TransformerInterface
{
    use CommonTransformers;

    public function __construct()
    {
        $this->fileTransformer = resolve(FileTransformer::class);
    }

    /**
     * @inheritDoc
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Client) {
            return [];
        }

        return [
            'image' => $this->transformFile($item->logo),
            'width' => $item->logo_width,
            'opacity' => $item->logo_opacity
        ];
    }
}
