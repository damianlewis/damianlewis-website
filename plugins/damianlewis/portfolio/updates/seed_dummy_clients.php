<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use DamianLewis\Portfolio\Models\Client;
use Seeder;

class SeedDummyClients extends Seeder
{
    public function run(): void
    {
        factory(Client::class, 2)->create();
        factory(Client::class, 8)->states('visible')->create();
    }
}