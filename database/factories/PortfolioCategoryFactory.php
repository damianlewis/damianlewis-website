<?php

declare(strict_types=1);

use DamianLewis\Portfolio\Models\Category;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */

$factory->define(Category::class, function (Generator $faker) {
    return [
        'name' => ucwords($faker->unique()->words(rand(1, 3), true))
    ];
});
