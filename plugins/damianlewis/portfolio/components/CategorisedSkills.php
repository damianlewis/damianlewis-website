<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use DamianLewis\Api\Components\TransformerComponent;
use DamianLewis\Portfolio\Classes\Transformers\CategoriesTransformer;
use DamianLewis\Portfolio\Models\Category;
use October\Rain\Database\Collection;

class CategorisedSkills extends TransformerComponent
{
    public function componentDetails(): array
    {
        return [
            'name' => 'Skills',
            'description' => 'Get a collection of categorised skills.'
        ];
    }

    public function onRun(): void
    {
        $transformer = resolve(CategoriesTransformer::class);
        $rootCategories = $this->getRootCategories();

        $this->page['rootCategories'] = $this->transformCollection($rootCategories, $transformer);
    }

    /**
     * Returns the root level categories from the database.
     *
     * @return Collection
     */
    protected function getRootCategories(): Collection
    {
        return Category::root()
            ->visible()
            ->get();
    }
}
