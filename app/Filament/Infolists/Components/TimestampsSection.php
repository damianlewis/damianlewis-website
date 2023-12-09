<?php

namespace App\Filament\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Section;
use Illuminate\Contracts\Support\Htmlable;

class TimestampsSection extends Section
{
    public static function make(
        string|array|Htmlable|Closure|null $heading = null
    ): static {
        return parent::make($heading)
            ->schema([
                CreatedAtTextEntry::make()
                    ->color('gray'),
                UpdatedAtTextEntry::make()
                    ->color('gray'),
            ]);
    }
}
