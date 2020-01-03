<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use DamianLewis\Portfolio\Models\Testimonial;
use Seeder;

class SeedDummyTestimonials extends Seeder
{
    public function run(): void
    {
        factory(Testimonial::class, 4)->create();
        factory(Testimonial::class, 6)->states(['active', 'rated'])->create();
        factory(Testimonial::class, 2)->states(['active', 'hidden', 'rated'])->create();
    }
}