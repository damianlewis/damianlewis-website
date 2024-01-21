<?php

namespace App\Filament\Infolists\Components;

use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\FontFamily;

class ProseTextEntry extends TextEntry
{
    public static function make(string $name): static
    {
        return parent::make($name)
            ->extraAttributes(['class' => 'ring-1 ring-gray-950/5 dark:ring-white/10 rounded-xl px-6 py-4 pb-6'])
            ->prose();
    }
}
