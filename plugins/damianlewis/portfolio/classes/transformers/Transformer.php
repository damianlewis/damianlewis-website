<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use October\Rain\Database\Collection;

abstract class Transformer
{
    /**
     * Transform the models of the given collections to include specific attributes.
     *
     * @param  Collection  $collection
     *
     * @return array
     */
    public function transformCollection(Collection $collection): array
    {
        return $collection->map([$this, 'transformItem'])->all();
    }
}
