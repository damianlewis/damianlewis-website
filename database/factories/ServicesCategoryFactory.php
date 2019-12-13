<?php

declare(strict_types=1);

use BlogArticleFaker\FakerProvider as BlogArticleFaker;
use DamianLewis\Services\Models\Category;
use Faker\Generator;

$factory->define(Category::class, function (Generator $faker) {
    $faker->addProvider(new BlogArticleFaker($faker));

    return [
        'title' => ucwords($faker->unique()->word),
        'featured_text' => $faker->paragraph(3, true),
        'hero_text' => $faker->paragraph(3, true),
        'list_text' => $faker->paragraph(3, true),
        'description' => $faker->articleContent
    ];
});

$factory->state(Category::class, 'featured', function () {
    return [
        'is_featured' => true
    ];
});
