<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Skill;
use DamianLewis\Transformer\Classes\CanTransform;
use DamianLewis\Transformer\Classes\Transformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use Model;

class SkillTransformer extends Transformer implements TransformerInterface
{
    use CanTransform;

    /**
     * @inheritDoc
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Skill) {
            return [];
        }

        $data = $item->only([
            'name'
        ]);

        $data = array_merge($data, [
            'skills' => $this->transformCollectionOrNull($this, $item->getChildren())
        ]);

        return $data;
    }
}