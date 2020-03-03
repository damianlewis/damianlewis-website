<?php

declare(strict_types=1);

use DamianLewis\SocialMedia\Models\Link;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */

$factory->define(Link::class, function (Generator $faker) {
    return [
        'name' => ucwords($faker->unique()->words(rand(1, 3), true)),
        'url' => $faker->url
    ];
});

$factory->state(Link::class, 'blank', function () {
    return [
        'is_blank_target' => true
    ];
});

$factory->state(Link::class, 'visible', function () {
    return [
        'is_visible' => true
    ];
});
