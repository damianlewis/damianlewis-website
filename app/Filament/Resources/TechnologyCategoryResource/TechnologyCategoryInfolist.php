<?php

namespace App\Filament\Resources\TechnologyCategoryResource;

use App\Filament\Infolists\Components\DatesSection;
use App\Filament\Infolists\Components\EnabledIconEntry;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class TechnologyCategoryInfolist
{
    public static function make(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Details')
                            ->schema(
                                self::getDetailsSchema()
                            ),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        DatesSection::make(),
                        Section::make('Settings')
                            ->schema(
                                self::getSettingsSchema()
                            ),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function getDetailsSchema(): array
    {
        return [
            TextEntry::make('name'),
            TextEntry::make('slug'),
            TextEntry::make('description')
                ->html(),
        ];
    }

    public static function getSettingsSchema(): array
    {
        return [
            EnabledIconEntry::make(),
        ];
    }
}
