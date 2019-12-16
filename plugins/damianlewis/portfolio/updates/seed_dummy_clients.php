<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use Seeder;

class SeedDummyClients extends Seeder
{
    public function run()
    {
        $this->call(SeedClients::class);
    }
}
