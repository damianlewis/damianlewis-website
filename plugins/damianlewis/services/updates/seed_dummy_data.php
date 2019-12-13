<?php

declare(strict_types=1);

namespace DamianLewis\Services\Updates;

use Seeder;

class SeedDummyData extends Seeder
{
    public function run()
    {
        $this->call(SeedCategories::class);
    }
}