<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use App;
use Seeder;

class SeedDummyProjects extends Seeder
{
    public function run(): void
    {
        if (App::environment() == 'development') {
            $this->call(SeedSkills::class);
            $this->call(SeedProjects::class);
        }
    }
}
