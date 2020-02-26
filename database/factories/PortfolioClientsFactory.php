<?php

declare(strict_types=1);

use DamianLewis\Portfolio\Models\Client;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */

$factory->define(Client::class, function (Generator $faker) {
    return [
        'name' => ucwords($faker->unique()->words(rand(1, 3), true))
    ];
});

$factory->state(Client::class, 'hidden', function () {
    return [
        'is_hidden' => true
    ];
});
