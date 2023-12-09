<?php

namespace App\Filament\Infolists\Components;

use Filament\Infolists\Components\IconEntry;

class EnabledIconEntry extends IconEntry
{
    public static function make(
        ?string $name = 'enabled'
    ): static {
        return parent::make($name)
            ->boolean();
    }
}
