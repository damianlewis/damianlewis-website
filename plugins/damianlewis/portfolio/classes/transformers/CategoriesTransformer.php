<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Category;
use DamianLewis\Shared\Classes\HasRelation;
use DamianLewis\Transformer\Classes\CanTransform;
use DamianLewis\Transformer\Classes\Transformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use Model;

class CategoriesTransformer extends Transformer implements TransformerInterface
{
    use CanTransform;
    use HasRelation;

    /**
     * @inheritDoc
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Category) {
            return [];
        }

        $data = $item->only([
            'name'
        ]);

        $skills = $this->getRelation($item, 'skills');

        $skillTransformer = resolve(SkillTransformer::class);

        $data = array_merge($data, [
            'categories' => $this->transformCollectionOrNull($this, $item->getChildren()),
            'skills' => $this->transformCollectionOrNull($skillTransformer, $skills)
        ]);

        return $data;
    }
}
