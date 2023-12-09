<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\Model;

class UpdatedAtPlaceholder extends Placeholder
{
    public static function make(
        ?string $name = 'updated',
    ): static {
        return parent::make($name)
            ->content(fn (?Model $record): ?string => $record->updated_at?->format('d M Y H:i'));
    }
}
