<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use Cms\Classes\ComponentBase;
use DamianLewis\Portfolio\Models\Client;
use October\Rain\Database\Collection;

class Clients extends ComponentBase
{
    /**
     * @var Collection
     */
    public $clients;

    public function componentDetails(): array
    {
        return [
            'name' => 'Clients',
            'description' => 'Get a collection of active clients.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'orderBy' => [
                'title' => 'Order by',
                'description' => 'The attribute to order the clients by.',
                'type' => 'dropdown',
                'options' => [
                    'sort_order' => 'Sort Order',
                    'created_at' => 'Created Date',
                    'updated_at' => 'Updated Date',
                    'name' => 'Name'
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
            'active' => [
                'title' => 'Active',
                'description' => 'Only display active clients.',
                'type' => 'checkbox',
                'default' => false
            ],
            'limit' => [
                'title' => 'Maximum',
                'description' => 'Maximum number of clients to display.',
                'type' => 'string',
                'validationPattern' => '^[\d]*$',
                'validationMessage' => 'The value can only contain numbers.',
            ],
        ];
    }

    public function onRun(): void
    {
        $this->clients = $this->page['clients'] = $this->getClients();
    }

    /**
     * Return an ordered collection of clients.
     *
     * @return Collection
     */
    protected function getClients(): Collection
    {
        $limit = $this->property('limit');

        return Client::query()
            ->when($this->property('active'), function ($query) {
                return $query->active();
            })
            ->when($limit > 0, function ($query) use ($limit) {
                return $query->take($limit);
            })
            ->orderBy($this->property('orderBy'), $this->property('orderDirection'))
            ->get();
    }
}
