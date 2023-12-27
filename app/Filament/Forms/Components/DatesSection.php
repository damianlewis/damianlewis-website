<?php

namespace App\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\Section;
use Illuminate\Contracts\Support\Htmlable;

class DatesSection extends Section
{
    public static function make(
        string|array|Htmlable|Closure|null $heading = 'Dates'
    ): static {
        return parent::make($heading)
            ->schema([
                CreatedAtPlaceholder::make(),
                UpdatedAtPlaceholder::make(),
                DeletedAtPlaceholder::make(),
            ])
            ->hiddenOn('create')
            ->columns();
    }
}