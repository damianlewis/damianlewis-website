<?php

namespace App\Filament\Forms\Components;

class CreatedAtPlaceholder extends DateTimePlaceholder
{
    public static function make(?string $name = 'created_at'): static
    {
        return parent::make($name)
            ->label('Created');
    }
}
