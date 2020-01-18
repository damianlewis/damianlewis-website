<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use DamianLewis\Portfolio\Classes\Transformers\ServicesTransformer;
use DamianLewis\Portfolio\Models\Service;
use DamianLewis\Transformer\Components\TransformerComponent;
use October\Rain\Database\Collection;

class ServicesList extends TransformerComponent
{
    /**
     * @var ServicesTransformer
     */
    protected $transformer;

    public function componentDetails(): array
    {
        return [
            'name' => 'Services',
            'description' => 'Get a collection of services.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'orderBy' => [
                'title' => 'Order by',
                'description' => 'The attribute to order the services by.',
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
                'description' => 'Maximum number of services to display.',
                'type' => 'string',
                'validationPattern' => '^[\d]*$',
                'validationMessage' => 'The value can only contain numbers.',
            ],
            'includeIcon' => [
                'title' => 'Display icon',
                'type' => 'checkbox',
                'description' => 'Include the service icon.',
                'default' => false
            ]
        ];
    }

    public function init(): void
    {
        $this->transformer = resolve(ServicesTransformer::class);
    }

    public function onRun()
    {
        $services = $this->getServices();

        $this->transformer->setIncludeIcon($this->property('includeIcon') == true);

        $this->page['services'] = $this->transformCollection($services);
    }

    /**
     * Returns an array of order by options.
     *
     * @return array
     */
    public function getOrderByOptions(): array
    {
        return Service::$orderByOptions;
    }

    /**
     * Returns an array of order direction options.
     *
     * @return array
     */
    public function getOrderDirectionOptions(): array
    {
        return Service::$orderDirectionOptions;
    }

    /**
     * Return an ordered collection of services from the database.
     *
     * @return Collection
     */
    protected function getServices(): Collection
    {
        $options = [
            'limit' => (int) $this->property('limit'),
            'orderBy' => $this->property('orderBy'),
            'orderDirection' => $this->property('orderDirection')
        ];

        return Service::frontEndCollection($options)->get();
    }
}
