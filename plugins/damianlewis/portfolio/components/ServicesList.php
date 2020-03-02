<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use DamianLewis\Api\Components\TransformerComponent;
use DamianLewis\Portfolio\Classes\Transformers\ServicesTransformer;
use DamianLewis\Portfolio\Models\Service;
use October\Rain\Database\Collection;

class ServicesList extends TransformerComponent
{
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

    public function onRun()
    {
        $transformer = resolve(ServicesTransformer::class);
        $transformer->setIncludeIcon($this->property('includeIcon') == true);
        $services = $this->getServices();

        $this->page['services'] = $this->transformCollection($services, $transformer);
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
     * Return an ordered collection of listed services from the database.
     *
     * @return Collection
     */
    protected function getServices(): Collection
    {
        $options = [
            'listed' => true,
            'limit' => (int) $this->property('limit'),
            'orderBy' => $this->property('orderBy'),
            'orderDirection' => $this->property('orderDirection')
        ];

        return Service::frontEndCollection($options)->get();
    }
}
