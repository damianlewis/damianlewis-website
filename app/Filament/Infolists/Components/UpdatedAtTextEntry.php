<?php

namespace App\Filament\Infolists\Components;

use Illuminate\Database\Eloquent\Model;

class UpdatedAtTextEntry extends DateTimeTextEntry
{
    public static function make(
        ?string $name = 'updated_at'
    ): static {
        return parent::make($name)
            ->label('Updated')
            ->hidden(fn (Model $record): bool => $record->updated_at === null);
    }
}
