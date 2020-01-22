<?php

declare(strict_types=1);

use DamianLewis\Portfolio\Models\Category;
use Faker\Generator;

$factory->define(Category::class, function (Generator $faker) {
    return [
        'name' => ucwords($faker->unique()->words(rand(1, 3), true))
    ];
});
