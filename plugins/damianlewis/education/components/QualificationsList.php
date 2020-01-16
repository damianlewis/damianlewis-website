<?php

declare(strict_types=1);

namespace Damianlewis\Education\Components;

use DamianLewis\Education\Classes\Transformers\QualificationsTransformer;
use DamianLewis\Education\Models\Qualification;
use DamianLewis\Transformer\Components\TransformerComponent;
use October\Rain\Database\Collection;

class QualificationsList extends TransformerComponent
{
    /**
     * @var QualificationsTransformer
     */
    protected $transformer;

    public function componentDetails(): array
    {
        return [
            'name' => 'Qualifications',
            'description' => 'Get a collection of qualifications.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'orderBy' => [
                'title' => 'Order by',
                'description' => 'The attribute to order the qualifications by.',
                'type' => 'dropdown',
                'default' => 'sort_order'
            ],
            'orderDirection' => [
                'title' => 'Order direction',
                'type' => 'dropdown',
                'default' => 'asc'
            ],
            'includeCompletedDate' => [
                'title' => 'Completed date',
                'type' => 'checkbox',
                'description' => 'Include the completed date..',
                'default' => false
            ]
        ];
    }

    public function init(): void
    {
        $this->transformer = resolve(QualificationsTransformer::class);
    }

    public function onRun(): void
    {
        $qualifications = $this->getQualifications();

        $this->transformer->setIncludeCompletedDate($this->property('includeCompletedDate') === true);

        $this->page['qualifications'] = $this->transformCollection($qualifications);
    }

    /**
     * Returns an array of order by options.
     *
     * @return array
     */
    public function getOrderByOptions(): array
    {
        return Qualification::$orderByOptions;
    }

    /**
     * Returns an array of order direction options.
     *
     * @return array
     */
    public function getOrderDirectionOptions(): array
    {
        return Qualification::$orderDirectionOptions;
    }

    /**
     * Returns an ordered collection of qualifications from the database.
     *
     * @return Collection
     */
    protected function getQualifications(): Collection
    {
        $options = [
            'orderBy' => $this->property('orderBy'),
            'orderDirection' => $this->property('orderDirection')
        ];

        return Qualification::frontEndCollection($options)->get();
    }
}
