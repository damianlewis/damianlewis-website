<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Providers;

use DamianLewis\Portfolio\Classes\Transformers\AttributeTransformer;
use DamianLewis\Portfolio\Classes\Transformers\ProjectListTransformer;
use DamianLewis\Portfolio\Classes\Transformers\ProjectTransformer;
use DamianLewis\Portfolio\Classes\Transformers\TestimonialTransformer;
use October\Rain\Support\ServiceProvider;

class TransformerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AttributeTransformer::class, function () {
            return new AttributeTransformer();
        });

        $this->app->bind(ProjectListTransformer::class, function () {
            return new ProjectListTransformer();
        });

        $this->app->bind(ProjectTransformer::class, function () {
            return new ProjectTransformer();
        });

        $this->app->bind(TestimonialTransformer::class, function () {
            return new TestimonialTransformer();
        });
    }
}