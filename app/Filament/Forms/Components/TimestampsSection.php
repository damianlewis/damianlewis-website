<?php

namespace App\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\Section;
use Illuminate\Contracts\Support\Htmlable;

class TimestampsSection extends Section
{
    public static function make(
        string|array|Htmlable|Closure|null $heading = null
    ): static {
        return parent::make($heading)
            ->schema([
                CreatedAtPlaceholder::make(),
                UpdatedAtPlaceholder::make(),
            ])
            ->hiddenOn('create');
    }
}
