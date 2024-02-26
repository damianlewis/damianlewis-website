<?php

namespace App\Filament\Infolists\Components;

class UpdatedAtTextEntry extends DateTimeTextEntry
{
    public static function make(?string $name = 'updated_at'): static
    {
        return parent::make($name)
            ->label('Updated');
    }
}
