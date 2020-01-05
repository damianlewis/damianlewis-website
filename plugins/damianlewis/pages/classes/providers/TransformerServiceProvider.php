<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Classes\Providers;

use DamianLewis\Pages\Classes\Transformers\HeroTransformer;
use October\Rain\Support\ServiceProvider;

class TransformerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(HeroTransformer::class, function () {
            return new HeroTransformer();
        });
    }
}
