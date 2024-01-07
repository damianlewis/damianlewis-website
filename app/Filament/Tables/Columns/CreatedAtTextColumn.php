<?php

namespace App\Filament\Tables\Columns;

class CreatedAtTextColumn extends DateTimeTextColumn
{
    public static function make(?string $name = 'created_at'): static
    {
        return parent::make($name)
            ->label('Created')
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
