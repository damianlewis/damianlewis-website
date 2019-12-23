<?php

declare(strict_types=1);

namespace DamianLewis\Services\Components;

use Closure;
use Cms\Classes\ComponentBase;
use DamianLewis\Services\Models\Category;
use October\Rain\Database\Collection;

class FeaturedCategories extends ComponentBase
{
    /**
     * @var Collection
     */
    private $categories;

    public function componentDetails(): array
    {
        return [
            'name' => 'Featured Categories',
            'description' => 'Get a collection of featured service categories.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'orderBy' => [
                'title' => 'Order by',
                'description' => 'The attribute to order the categories by.',
                'type' => 'dropdown',
                'default' => 'sort_order'
            ],
            'orderDirection' => [
                'title' => 'Order direction',
                'type' => 'dropdown',
                'default' => 'asc'
            ],
            'limit' => [
                'title' => 'Maximum',
                'description' => 'Maximum number of categories to display.',
                'type' => 'string',
                'validationPattern' => '^[\d]*$',
                'validationMessage' => 'The value can only contain numbers.'
            ]
        ];
    }

    /**
     * Returns an array of order by options.
     *
     * @return array
     */
    public function getOrderByOptions(): array
    {
        return Category::$orderByOptions;
    }

    /**
     * Returns an array of order direction options.
     *
     * @return array
     */
    public function getOrderDirectionOptions(): array
    {
        return Category::$orderDirectionOptions;
    }

    public function onRun(): void
    {
        $this->categories = $this->getCategories();
    }

    /**
     * Returns an array of transformed categories for consumption by the frontend.
     *
     * @return array The transformed collection.
     */
    public function collection(): array
    {
        if (!$this->isAvailable()) {
            return [];
        }

        return $this->transformCollection($this->categories);
    }

    /**
     * Returns true if a collection of categories has been fetched from the database.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        if ($this->categories === null) {
            return false;
        }

        if ($this->categories->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Returns an ordered collection of featured service categories.
     *
     * @return Collection
     */
    protected function getCategories(): Collection
    {
        $options = [
            'featured' => true,
            'limit' => (int) $this->property('limit'),
            'orderBy' => $this->property('orderBy'),
            'orderDirection' => $this->property('orderDirection')
        ];

        return Category::frontEndCollection($options)->get();
    }

    /**
     * Transforms a categories collection into the data required by the frontend.
     *
     * @param  Collection  $categories
     * @return array
     */
    protected function transformCollection(Collection $categories): array
    {
        return array_map(
            $this->transformItem(),
            $categories->all()
        );
    }

    /**
     * Transforms a category model into the data required by the frontend.
     *
     * @return Closure
     */
    protected function transformItem(): Closure
    {
        return function (Category $category) {
            $data = $category->only([
                'title'
            ]);

            return array_merge($data, [
                'icon' => $category->featured_icon,
                'text' => $category->featured_text
            ]);
        };
    }
}
