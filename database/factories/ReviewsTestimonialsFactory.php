<?php

declare(strict_types=1);

use DamianLewis\Reviews\Models\Testimonial;
use Faker\Generator;

$factory->define(Testimonial::class, function (Generator $faker) {
    return [
        'name' => $faker->firstName.' '.$faker->lastName,
        'company' => $faker->company,
        'quote' => $faker->paragraph(3, true)
    ];
});

$factory->state(Testimonial::class, 'rated', function (Generator $faker) {
    return [
        'rating' => $faker->numberBetween(1, 5)
    ];
});

$factory->state(Testimonial::class, 'active', function () {
    return [
        'is_active' => true
    ];
});
