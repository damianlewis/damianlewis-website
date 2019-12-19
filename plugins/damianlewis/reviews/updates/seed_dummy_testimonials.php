<?php

declare(strict_types=1);

namespace DamianLewis\Reviews\Updates;

use Seeder;

class SeedDummyTestimonials extends Seeder
{
    public function run(): void
    {
        $this->call(SeedTestimonials::class);
    }
}