<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Toggle;

class EnabledToggle extends Toggle
{
    public static function make(
        ?string $name = 'enabled',
    ): static {
        return parent::make($name)
            ->onColor('success')
            ->offColor('gray')
            ->rule('boolean');
    }
}
