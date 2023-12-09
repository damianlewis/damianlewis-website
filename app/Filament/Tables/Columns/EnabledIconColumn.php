<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\IconColumn;

class EnabledIconColumn extends IconColumn
{
    public static function make(
        ?string $name = 'enabled'
    ): static {
        return parent::make($name)
            ->boolean()
            ->sortable();
    }
}
