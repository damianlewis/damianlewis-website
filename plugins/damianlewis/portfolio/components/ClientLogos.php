<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use Cms\Classes\ComponentBase;
use DamianLewis\Portfolio\Classes\Transformers\ClientLogosTransformer;
use DamianLewis\Portfolio\Models\Client;
use October\Rain\Database\Collection;

class ClientLogos extends ComponentBase
{
    /**
     * @var ClientLogosTransformer
     */
    protected ClientLogosTransformer $transformer;

    /**
     * @var array|null
     */
    protected ?array $transformedClients = null;

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


    public function init(): void
    {
        $this->transformer = resolve(ClientLogosTransformer::class);
    }

    public function onRun(): void
    {
        $clients = $this->getClients();

        $this->page['clientLogos'] = $this->transformClients($clients);
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

    /**
     * Return an ordered collection of clients from the database.
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
     * Returns an array of transformed clients.
     *
     * @param  Collection  $clients
     * @return array
     */
    protected function transformClients(Collection $clients): array
    {
        if ($this->transformedClients !== null) {
            return $this->transformedClients;
        }

        return $this->transformedClients = $this->transformer->transformCollection($clients);
    }
}
