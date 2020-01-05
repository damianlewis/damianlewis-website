<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Skill;
use DamianLewis\Portfolio\Models\Technology;
use DamianLewis\Transformer\Classes\Transformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use Model;

class AttributeTransformer extends Transformer implements TransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transformItem(Model $item): array
    {
        if (!($item instanceof Skill || $item instanceof Technology)) {
            return [];
        }

        return $item->only([
            'name'
        ]);
    }
}