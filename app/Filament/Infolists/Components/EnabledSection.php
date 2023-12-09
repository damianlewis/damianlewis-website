<?php

namespace App\Filament\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Section;
use Illuminate\Contracts\Support\Htmlable;

class EnabledSection extends Section
{
    public static function make(
        string|array|Htmlable|Closure|null $heading = null
    ): static {
        return parent::make($heading)
            ->schema([
                EnabledIconEntry::make(),
            ]);
    }
}
