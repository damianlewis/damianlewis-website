<?php

namespace App\Filament\Infolists\Components;

class CreatedAtTextEntry extends DateTimeTextEntry
{
    public static function make(
        ?string $name = 'created_at'
    ): static {
        return parent::make($name)
            ->label('Created');
    }
}
