<?php

declare(strict_types=1);

use DamianLewis\Portfolio\Models\Service;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */

$factory->define(Service::class, function (Generator $faker) {
    return [
        'title' => ucwords($faker->unique()->words(rand(3, 6), true)),
        'description' => $faker->paragraph(3, true)
    ];
});

$factory->state(Service::class, 'featured', function () {
    return [
        'is_featured' => true
    ];
});

$factory->state(Service::class, 'hidden', function () {
    return [
        'is_hidden' => true
    ];
});

$factory->state(Service::class, 'listed', function () {
    return [
        'is_listed' => true
    ];
});
