<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Classes\Transformers;

use DamianLewis\Pages\Models\Hero;
use DamianLewis\Transformer\Classes\FileTransformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use Model;
use System\Models\File;

class HeroTransformer implements TransformerInterface
{
    /**
     * @var FileTransformer
     */
    protected FileTransformer $fileTransformer;

    public function __construct()
    {
        $this->fileTransformer = resolve(FileTransformer::class);
    }

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

        $data = array_merge($data, [
            'image' => $this->transformFile($item->image),
            'bgTablet' => $this->transformFile($item->background_image_tablet),
            'bgMobile' => $this->transformFile($item->background_image_mobile)
        ]);

        return $data;
    }

    /**
     * Transforms the given file model or returns null.
     *
     * @param  Model|null  $model
     * @return array|null
     */
    protected function transformFile(?Model $model): ?array
    {
        if ($model instanceof File) {
            return $this->fileTransformer->transformItem($model);
        }

        return null;
    }
}
