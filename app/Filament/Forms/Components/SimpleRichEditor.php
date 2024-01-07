<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\RichEditor;

class SimpleRichEditor extends RichEditor
{
    public static function make(string $name): static
    {
        return parent::make($name)
            ->disableToolbarButtons([
                'attachFiles',
                'blockquote',
                'codeBlock',
            ])
            ->maxLength(65535);
    }
}
