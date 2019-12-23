<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use DamianLewis\Portfolio\Models\Technology;
use Seeder;

class SeedTechnologies extends Seeder
{
    public function run(): void
    {
        factory(Technology::class, 10)->create();
    }
}
