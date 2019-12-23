<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use Closure;
use Cms\Classes\ComponentBase;
use DamianLewis\Portfolio\Models\Client;
use October\Rain\Database\Collection;

class ClientLogos extends ComponentBase
{
    /**
     * @var Collection
     */
    private $clients;

    public function componentDetails(): array
    {
        return [
            'name' => 'Client Logos',
            'description' => 'Get a collection of client logos.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'orderBy' => [
                'title' => 'Order by',
                'description' => 'The attribute to order the clients by.',
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
                'description' => 'Maximum number of clients to display.',
                'type' => 'string',
                'validationPattern' => '^[\d]*$',
                'validationMessage' => 'The value can only contain numbers.',
            ],
        ];
    }

    /**
     * Returns an array of order by options.
     *
     * @return array
     */
    public function getOrderByOptions(): array
    {
        return Client::$orderByOptions;
    }

    /**
     * Returns an array of order direction options.
     *
     * @return array
     */
    public function getOrderDirectionOptions(): array
    {
        return Client::$orderDirectionOptions;
    }

    public function onRun(): void
    {
        $this->clients = $this->getClients();
    }

    /**
     * Returns an array of transformed clients for consumption by the frontend.
     *
     * @return array The transformed collection.
     */
    public function collection(): array
    {
        if (!$this->isAvailable()) {
            return [];
        }

        return $this->transformCollection($this->clients);
    }

    /**
     * Returns true if a collection of clients has been fetched from the database.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        if ($this->clients === null) {
            return false;
        }

        if ($this->clients->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Return an ordered collection of clients.
     *
     * @return Collection
     */
    protected function getClients(): Collection
    {
        $options = [
            'limit' => (int) $this->property('limit'),
            'orderBy' => $this->property('orderBy'),
            'orderDirection' => $this->property('orderDirection')
        ];

        return Client::frontEndCollection($options)->get();
    }

    /**
     * Transforms a clients collection into the data required by the frontend.
     *
     * @param  Collection  $clients
     * @return array
     */
    protected function transformCollection(Collection $clients): array
    {
        return array_map(
            $this->transformItem(),
            $clients->all()
        );
    }

    /**
     * Transforms a client model into the data required by the frontend.
     *
     * @return Closure
     */
    protected function transformItem(): Closure
    {
        return function (Client $category) {
            return [
                'image' => $category->logo,
                'width' => $category->logo_width,
                'opacity' => $category->logo_opacity
            ];
        };
    }
}
