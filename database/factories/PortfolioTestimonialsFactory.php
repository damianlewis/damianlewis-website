<?php

declare(strict_types=1);

use DamianLewis\Portfolio\Models\Testimonial;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */

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

$factory->state(Testimonial::class, 'featured', function () {
    return [
        'is_featured' => true
    ];
});

$factory->state(Testimonial::class, 'hidden', function () {
    return [
        'is_hidden' => true
    ];
});
