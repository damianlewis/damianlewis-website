<?php

namespace App\Filament\Forms\Components;

class UpdatedAtPlaceholder extends DateTimePlaceholder
{
    public static function make(
        ?string $name = 'updated_at',
    ): static {
        return parent::make($name)
            ->label('Updated');
    }
}
