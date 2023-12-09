<?php

namespace App\Filament\Infolists\Components;

use Filament\Infolists\Components\TextEntry;

class DateTimeTextEntry extends TextEntry
{
    public static function make(
        string $name
    ): static {
        return parent::make($name)
            ->dateTime('d M Y H:i');
    }
}
