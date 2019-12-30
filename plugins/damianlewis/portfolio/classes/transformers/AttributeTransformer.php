<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use Model;

class AttributeTransformer extends Transformer implements TransformerInterface
{
    /**
     * Transforms the given attribute model to include the attributes required by the frontend.
     *
     * @param  Model  $item
     * @return array
     */
    public function transformItem(Model $item): array
    {
        return $item->only([
            'name'
        ]);
    }
}