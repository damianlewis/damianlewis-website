<?php

declare(strict_types=1);

use BlogArticleFaker\FakerProvider as BlogArticleFaker;
use DamianLewis\Portfolio\Models\Attribute;
use DamianLewis\Portfolio\Models\Project;
use DamianLewis\Portfolio\Models\Skill;
use DamianLewis\Portfolio\Models\Technology;
use Faker\Generator;
use Illuminate\Http\UploadedFile;

$factory->define(Project::class, function (Generator $faker) {
    $faker->addProvider(new BlogArticleFaker($faker));

    $attribute = Attribute::where([
        ['type', Attribute::PROJECT_STATUS],
        ['code', 'draft']
    ])->firstOrFail();

    return [
        'title' => ucwords($faker->unique()->words(rand(3, 6), true)),
        'tag_line' => $faker->sentence(3, true),
        'summary' => $faker->paragraph(3, true),
        'description' => $faker->articleContent,
        'status' => function () use ($attribute) {
            return $attribute->id;
        },
        'completed_at' => $faker->dateTimeBetween('-10 years')
    ];
});

$factory->state(Project::class, 'active', function () {
    $attribute = Attribute::where([
        ['type', Attribute::PROJECT_STATUS],
        ['code', 'active']
    ])->firstOrFail();

    return [
        'status' => function () use ($attribute) {
            return $attribute->id;
        }
    ];
});

$factory->state(Project::class, 'archived', function () {
    $attribute = Attribute::where([
        ['type', Attribute::PROJECT_STATUS],
        ['code', 'archived']
    ])->firstOrFail();

    return [
        'status' => function () use ($attribute) {
            return $attribute->id;
        }
    ];
});

$factory->state(Project::class, 'featured', function () {
    return [
        'is_featured' => true
    ];
});

$factory->state(Project::class, 'hidden', function () {
    return [
        'is_hidden'=>true
    ];
});

$factory->state(Project::class, 'with skills', function () {
    $total = Skill::count();

    return [
        'skills' => Skill::inRandomOrder()->take(rand(1, $total))->get()->all()
    ];
});


$factory->state(Project::class, 'with technologies', function () {
    $total = Technology::count();

    return [
        'technologies' => Technology::inRandomOrder()->take(rand(1, $total))->get()->all()
    ];
});

$factory->state(Project::class, 'with preview', function (Generator $faker) {
    return [
        'preview_image' => UploadedFile::fake()->image('preview_image.jpg', 640, 480)
    ];
});

$factory->state(Project::class, 'with device images', function (Generator $faker) {
    return [
        'devices_in_sequence_image' => UploadedFile::fake()->image('devices_in_sequence_image.jpg', 1140, 748),
        'devices_at_angle_image' => UploadedFile::fake()->image('devices_at_angle_image.jpg', 546, 306),
        'devices_desktop' => UploadedFile::fake()->image('devices_desktop.jpg', 594, 501)
    ];
});

$factory->state(Project::class, 'with full frame images', function (Generator $faker) {
    return [
        'desktop_whole_frame_image' => UploadedFile::fake()->image('desktop_whole_frame_image.jpg', 1140, 1390),
        'tablet_whole_frame_image' => UploadedFile::fake()->image('tablet_whole_frame_image.jpg', 696, 888),
        'mobile_whole_frame_image' => UploadedFile::fake()->image('mobile_whole_frame_image.jpg', 272, 1454),
    ];
});
