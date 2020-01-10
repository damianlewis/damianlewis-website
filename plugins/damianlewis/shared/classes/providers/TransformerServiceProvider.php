<?php

declare(strict_types=1);

namespace DamianLewis\Shared\Classes\Providers;

use DamianLewis\Transformer\Classes\Transformers\FileTransformer;
use October\Rain\Support\ServiceProvider;

class TransformerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(FileTransformer::class, function () {
            return new FileTransformer();
        });
    }
}