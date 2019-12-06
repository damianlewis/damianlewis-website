<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use Seeder;

class SeedDummyData extends Seeder
{
    public function run()
    {
        $this->call(SeedSkills::class);
        $this->call(SeedTechnologies::class);
        $this->call(SeedProjects::class);
    }
}
