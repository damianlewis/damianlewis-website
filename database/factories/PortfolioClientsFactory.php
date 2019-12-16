<?php

declare(strict_types=1);

use DamianLewis\Portfolio\Models\Client;
use Faker\Generator;

$factory->define(Client::class, function (Generator $faker) {
    return [
        'name' => ucwords($faker->unique()->words(rand(1, 3), true))
    ];
});

$factory->state(Client::class, 'active', function () {
    return [
        'is_active' => true
    ];
});
