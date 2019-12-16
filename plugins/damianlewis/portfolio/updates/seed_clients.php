<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use DamianLewis\Portfolio\Models\Client;
use Seeder;

class SeedClients extends Seeder
{
    public function run()
    {
        factory(Client::class, 2)->create();
        factory(Client::class, 8)->states('active')->create();
    }
}