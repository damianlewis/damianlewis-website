<?php

declare(strict_types=1);

namespace DamianLewis\Services\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use DamianLewis\Services\Models\Category;
use October\Rain\Database\Collection;

class Categories extends ComponentBase
{
    /**
     * @var Collection|string
     */
    public $categories;

    public function componentDetails(): array
    {
        return [
            'name' => 'Categories',
            'description' => 'Get a collection of service categories.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'orderBy' => [
                'title' => 'Order by',
                'description' => 'The attribute to order the categories by.',
                'type' => 'dropdown',
                'options' => [
                    'sort_order' => 'Sort Order',
                    'created_at' => 'Created Date',
                    'updated_at' => 'Updated Date',
                    'title' => 'Title'
                ],
                'default' => 'sort_order'
            ],
            'orderDirection' => [
                'title' => 'Order direction',
                'type' => 'dropdown',
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ],
                'default' => 'asc'
            ],
            'featured' => [
                'title' => 'Featured',
                'description' => 'Only display featured categories.',
                'type' => 'checkbox',
                'default' => false
            ],
            'limit' => [
                'title' => 'Maximum',
                'description' => 'Maximum number of categories to display.',
                'type' => 'string',
                'validationPattern' => '^[\d]*$',
                'validationMessage' => 'The value can only contain numbers.'
            ],
            'categoryPage' => [
                'title' => 'Categories page',
                'description' => 'The page used to display the category details.',
                'type' => 'dropdown'
            ]
        ];
    }

    /**
     * Return an array of CMS pages.
     *
     * @return array
     */
    public function getCategoryPageOptions(): array
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun(): void
    {
        $this->categories = $this->page['categories'] = $this->getCategories();

        $this->setUrlForCategories($this->categories);
    }

    /**
     * Return an ordered collection of service categories.
     *
     * @return Collection
     */
    protected function getCategories(): Collection
    {
        $limit = $this->property('limit');

        return Category::query()
            ->when($this->property('featured'), function ($query) {
                return $query->featured();
            })
            ->when($limit > 0, function ($query) use ($limit) {
                return $query->take($limit);
            })
            ->orderBy($this->property('orderBy'), $this->property('orderDirection'))
            ->get();
    }

    /**
     * Set the page URL for the service categories.
     *
     * @param  Collection  $categories
     */
    protected function setUrlForCategories(Collection $categories)
    {
        $categories->each(function (Category $category) {
            $category->setUrl($this->property('categoryPage'), $this->controller);
        });
    }
}
