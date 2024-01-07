<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class DateTimeTextColumn extends TextColumn
{
    public static function make(string $name): static
    {
        return parent::make($name)
            ->dateTime('d M Y H:i');
    }
}
