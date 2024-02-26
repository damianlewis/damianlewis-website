<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\Model;

class DateTimePlaceholder extends Placeholder
{
    public static function make(string $name): static
    {
        return parent::make($name)
            ->content(
                fn (Model $record): ?string => $record->$name?->format('j M Y H:i')
            );
    }
}
