<?php

namespace App\Filament\Infolists\Components;

use Illuminate\Database\Eloquent\Model;

class CreatedAtTextEntry extends DateTimeTextEntry
{
    public static function make(
        ?string $name = 'created_at'
    ): static {
        return parent::make($name)
            ->label('Created')
            ->hidden(fn (Model $record): bool => $record->created_at === null);
    }
}
