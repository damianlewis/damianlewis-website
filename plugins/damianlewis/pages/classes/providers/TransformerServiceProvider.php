<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Classes\Providers;

use DamianLewis\Pages\Classes\Transformers\HeroTransformer;
use DamianLewis\Transformer\Classes\FileTransformer;
use October\Rain\Support\ServiceProvider;

class TransformerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(FileTransformer::class, function () {
            return new FileTransformer();
        });

        $this->app->bind(HeroTransformer::class, function () {
            return new HeroTransformer();
        });
    }
}
