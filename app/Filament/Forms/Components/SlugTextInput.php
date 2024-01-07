<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\TextInput;

class SlugTextInput extends TextInput
{
    public static function make(?string $name = 'slug'): static
    {
        return parent::make($name)
            ->required()
            ->alphaDash()
            ->maxLength(255)
            ->unique(ignoreRecord: true);
    }
}
