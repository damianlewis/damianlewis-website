<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use App;
use DamianLewis\Portfolio\Models\Testimonial;
use Seeder;

class SeedDummyTestimonials extends Seeder
{
    public function run(): void
    {
        if (App::environment() == 'development') {
            factory(Testimonial::class, 4)->create();
            factory(Testimonial::class, 6)->states(['rated'])->create();
            factory(Testimonial::class, 2)->states(['featured', 'hidden', 'rated'])->create();
        }
    }
}