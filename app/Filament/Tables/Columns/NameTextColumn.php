<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class NameTextColumn extends TextColumn
{
    public static function make(?string $name = 'name'): static
    {
        return parent::make($name)
            ->sortable()
            ->searchable();
    }
}
