<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use App;
use DamianLewis\Portfolio\Models\Client;
use Seeder;

class SeedDummyClients extends Seeder
{
    public function run(): void
    {
        if (App::environment() == 'development') {
            factory(Client::class, 8)->create();
            factory(Client::class, 2)->states('hidden')->create();
        }
    }
}