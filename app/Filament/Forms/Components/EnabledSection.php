<?php

namespace App\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\Section;
use Illuminate\Contracts\Support\Htmlable;

class EnabledSection extends Section
{
    public static function make(
        string|array|Htmlable|Closure|null $heading = null
    ): static {
        return parent::make($heading)
            ->schema([
                EnabledToggle::make(),
            ]);
    }
}
