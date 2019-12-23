<?php

declare(strict_types=1);

namespace DamianLewis\Reviews\Updates;

use DamianLewis\Reviews\Models\Testimonial;
use Seeder;

class SeedDummyTestimonials extends Seeder
{
    public function run(): void
    {
        factory(Testimonial::class, 4)->create();
        factory(Testimonial::class, 6)->states(['active', 'rated'])->create();
    }
}