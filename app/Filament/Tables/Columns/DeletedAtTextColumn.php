<?php

namespace App\Filament\Tables\Columns;

class DeletedAtTextColumn extends DateTimeTextColumn
{
    public static function make(
        ?string $name = 'deleted_at'
    ): static {
        return parent::make($name)
            ->label('Deleted')
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
