<?php

namespace App\Filament\Resources\SkillCategoryResource;

use App\Filament\Infolists\Components\DatesSection;
use App\Filament\Infolists\Components\EnabledIconEntry;
use App\Filament\Infolists\Components\ProseTextEntry;
use App\Filament\Infolists\Components\SlugTextEntry;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class SkillCategoryInfolist
{
    public static function make(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Group::make()
                    ->schema([
                        self::getDetailsSection(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        DatesSection::make(),
                        self::getSettingsSection(),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function getDetailsSection(): Section
    {
        return Section::make('Details')
            ->schema(self::getDetailsSchema());
    }

    public static function getSettingsSection(): Section
    {
        return Section::make('Settings')
            ->schema(self::getSettingsSchema());
    }

    public static function getDetailsSchema(): array
    {
        return [
            TextEntry::make('name'),
            SlugTextEntry::make(),
            ProseTextEntry::make('description'),
        ];
    }

    public static function getSettingsSchema(): array
    {
        return [
            EnabledIconEntry::make(),
        ];
    }
}
