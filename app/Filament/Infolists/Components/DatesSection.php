<?php

namespace App\Filament\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Section;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class DatesSection extends Section
{
    public static function make(
        string|array|Htmlable|Closure|null $heading = 'Dates'
    ): static {
        return parent::make($heading)
            ->schema([
                CreatedAtTextEntry::make(),
                UpdatedAtTextEntry::make(),
                DeletedAtTextEntry::make()
                    ->visible(fn (Model $record): bool => $record->trashed()),
            ])
            ->columns();
    }
}
