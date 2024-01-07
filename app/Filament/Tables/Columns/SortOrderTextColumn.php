<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class SortOrderTextColumn extends TextColumn
{
    public static function make(?string $name = null): static
    {
        return parent::make($name ?? config('eloquent-sortable.order_column_name'))
            ->label('Sort Order')
            ->numeric()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
