<?php

namespace App\Filament\Tables\Columns;

use Filament\Support\Enums\FontFamily;
use Filament\Tables\Columns\TextColumn;

class SlugTextColumn extends TextColumn
{
    public static function make(?string $name = 'slug'): static
    {
        return parent::make($name)
            ->fontFamily(FontFamily::Mono)
            ->sortable()
            ->searchable()
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
