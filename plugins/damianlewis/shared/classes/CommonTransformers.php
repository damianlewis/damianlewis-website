<?php

declare(strict_types=1);

namespace DamianLewis\Shared\Classes;

use DamianLewis\Transformer\Classes\FileTransformer;
use Model;
use October\Rain\Database\Collection;
use System\Models\File;

trait CommonTransformers
{
    /**
     * @var FileTransformer
     */
    protected FileTransformer $fileTransformer;

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

    /**
     * Transforms the given file collection or returns null.
     *
     * @param  Collection  $collection
     * @return array|null
     */
    protected function transformFiles(Collection $collection): ?array
    {
        if ($collection->count() > 0) {
            return $this->fileTransformer->transformCollection($collection);
        }

        return null;
    }
}
