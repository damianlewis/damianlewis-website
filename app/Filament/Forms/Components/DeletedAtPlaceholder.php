<?php

namespace App\Filament\Forms\Components;

class DeletedAtPlaceholder extends DateTimePlaceholder
{
    public static function make(?string $name = 'deleted_at'): static
    {
        return parent::make($name)
            ->label('Deleted');
    }
}
