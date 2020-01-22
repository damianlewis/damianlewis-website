<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use DamianLewis\Portfolio\Models\Service;
use October\Rain\Database\Collection;

class FeaturedServices extends ServicesList
{
    public function componentDetails(): array
    {
        return [
            'name' => 'Featured services',
            'description' => 'Get a collection of featured services.'
        ];
    }

    /**
     * Return an ordered collection of featured services from the database.
     *
     * @return Collection
     */
    protected function getServices(): Collection
    {
        $options = [
            'featured' => true,
            'limit' => (int) $this->property('limit'),
            'orderBy' => $this->property('orderBy'),
            'orderDirection' => $this->property('orderDirection')
        ];

        return Service::frontEndCollection($options)->get();
    }
}
