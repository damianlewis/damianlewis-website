<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use Seeder;

class SeedDummyProjects extends Seeder
{
    public function run(): void
    {
        $this->call(SeedSkills::class);
        $this->call(SeedProjects::class);
    }
}
