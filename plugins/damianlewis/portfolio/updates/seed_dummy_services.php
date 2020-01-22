<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use App;
use DamianLewis\Portfolio\Models\Service;
use Seeder;

class SeedDummyServices extends Seeder
{
    public function run(): void
    {
        if (App::environment() == 'development') {
            factory(Service::class, 6)->create();
            factory(Service::class, 3)->states('featured')->create();
        }
    }
}