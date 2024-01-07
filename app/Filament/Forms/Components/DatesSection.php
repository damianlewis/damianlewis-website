<?php

namespace App\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\Section;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class DatesSection extends Section
{
    public static function make(
        string|array|Htmlable|Closure|null $heading = 'Dates'
    ): static {
        return parent::make($heading)
            ->schema([
                CreatedAtPlaceholder::make(),
                UpdatedAtPlaceholder::make(),
                DeletedAtPlaceholder::make()
                    ->visible(
                        fn (Model $record): bool => method_exists($record, 'trashed') && $record->trashed()
                    ),
            ])
            ->hiddenOn('create')
            ->columns();
    }
}
