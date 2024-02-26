<?php

namespace App\Filament\Infolists\Components;

use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\FontFamily;

class SlugTextEntry extends TextEntry
{
    public static function make(?string $name = 'slug'): static
    {
        return parent::make($name)
            ->label('Slug')
            ->fontFamily(FontFamily::Mono);
    }
}
