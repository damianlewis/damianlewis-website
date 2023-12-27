<?php

namespace App\Filament\Infolists\Components;

class DeletedAtTextEntry extends DateTimeTextEntry
{
    public static function make(
        ?string $name = 'deleted_at',
    ): static {
        return parent::make($name)
            ->label('Deleted');
    }
}
