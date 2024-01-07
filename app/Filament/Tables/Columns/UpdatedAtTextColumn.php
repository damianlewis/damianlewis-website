<?php

namespace App\Filament\Tables\Columns;

class UpdatedAtTextColumn extends DateTimeTextColumn
{
    public static function make(?string $name = 'updated_at'): static
    {
        return parent::make($name)
            ->label('Updated')
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
