<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Providers;

use DamianLewis\Api\Classes\Transformers\ImageTransformer;
use DamianLewis\Portfolio\Classes\Transformers\CategoriesTransformer;
use DamianLewis\Portfolio\Classes\Transformers\ProjectListTransformer;
use DamianLewis\Portfolio\Classes\Transformers\ProjectTransformer;
use DamianLewis\Portfolio\Classes\Transformers\ServicesTransformer;
use DamianLewis\Portfolio\Classes\Transformers\SkillTransformer;
use DamianLewis\Portfolio\Classes\Transformers\TestimonialTransformer;
use October\Rain\Support\ServiceProvider;

class TransformerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ImageTransformer::class, function () {
            return new ImageTransformer();
        });

        $this->app->bind(ProjectListTransformer::class, function () {
            return new ProjectListTransformer();
        });

        $this->app->bind(ProjectTransformer::class, function () {
            return new ProjectTransformer();
        });

        $this->app->bind(CategoriesTransformer::class, function () {
            return new CategoriesTransformer();
        });

        $this->app->bind(SkillTransformer::class, function () {
            return new SkillTransformer();
        });

        $this->app->bind(ServicesTransformer::class, function () {
            return new ServicesTransformer();
        });

        $this->app->bind(TestimonialTransformer::class, function () {
            return new TestimonialTransformer();
        });
    }
}