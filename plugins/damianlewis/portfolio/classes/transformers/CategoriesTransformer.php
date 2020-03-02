<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Api\Classes\Transformer;
use DamianLewis\Api\Classes\TransformerInterface;
use DamianLewis\Portfolio\Models\Category;
use League\Fractal\Resource\Collection;
use Model;

class CategoriesTransformer extends Transformer implements TransformerInterface
{
    protected $defaultIncludes = [
        'categories',
        'skills'
    ];

    /**
     * @inheritDoc
     */
    public function transform(Model $item): ?array
    {
        if (!$item instanceof Category) {
            return null;
        }

        $data = $item->only([
            'name'
        ]);

        return $data;
    }

    /**
     * Includes the related categories in the transformed data.
     *
     * @param  Category  $category
     * @return Collection
     */
    protected function includeCategories(Category $category): Collection
    {
        return $this->collection($category->getChildren(), $this);
    }

    /**
     * Includes the related skills in the transformed data.
     *
     * @param  Category  $category
     * @return Collection
     */
    protected function includeSkills(Category $category): Collection
    {
        return $this->collection($category->skills, resolve(SkillTransformer::class));
    }
}
