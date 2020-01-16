<?php

declare(strict_types=1);

namespace DamianLewis\Education\Classes\Providers;

use DamianLewis\Education\Classes\Transformers\QualificationsTransformer;
use October\Rain\Support\ServiceProvider;

class TransformerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(QualificationsTransformer::class, function () {
            return new QualificationsTransformer();
        });
    }
}