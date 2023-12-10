<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\Model;

class CreatedAtPlaceholder extends Placeholder
{
    public static function make(
        ?string $name = 'created',
    ): static {
        return parent::make($name)
            ->content(fn (Model $record): ?string => $record->created_at?->format('d M Y H:i'))
            ->hidden(fn (Model $record): ?bool => $record->created_at === null);
    }
}
