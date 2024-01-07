<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class NameTextInput extends TextInput
{
    public static function make(?string $name = 'name'): static
    {
        return parent::make($name)
            ->required()
            ->maxLength(255);
    }

    public static function forSlug(
        ?string $name = 'name',
        ?string $slug = 'slug',
    ): static {
        return self::make($name)
            ->unique(ignoreRecord: true)
            ->live()
            ->afterStateUpdated(
                function (Get $get, Set $set, ?string $old, ?string $state) use ($slug): void {
                    if (($get($slug) ?? '') !== Str::slug($old)) {
                        return;
                    }

                    $set($slug, Str::slug($state));
                }
            );
    }
}
