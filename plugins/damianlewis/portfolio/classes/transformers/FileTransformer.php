<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use Model;
use System\Models\File;

class FileTransformer extends Transformer implements TransformerInterface
{
    /**
     * Transforms the given file model to include the attributes required by the frontend.
     *
     * @param  Model|null  $item
     * @return array
     */
    public function transformItem(?Model $item): array
    {
        if (!$item instanceof File) {
            return [];
        }

        return [
            'path' => $item->getPath(),
            'title' => $item->title ?: ''
        ];
    }
}
