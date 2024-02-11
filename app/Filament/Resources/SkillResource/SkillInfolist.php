<?php

namespace App\Filament\Resources\SkillResource;

use App\Filament\Infolists\Components\DatesSection;
use App\Filament\Infolists\Components\EnabledIconEntry;
use App\Filament\Infolists\Components\SlugTextEntry;
use App\Models\Skill;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class SkillInfolist
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
                        self::getCategorySection(),
                        self::getParentSection(),
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

    public static function getCategorySection(): Section
    {
        return Section::make('Category')
            ->schema(self::getCategorySchema())
            ->visible(
                fn (Skill $record): bool => $record->hasCategory()
            );
    }

    public static function getParentSection(): Section
    {
        return Section::make('Parent')
            ->schema(self::getParentSchema())
            ->visible(
                fn (Skill $record): bool => $record->hasParent()
            );
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
        ];
    }

    public static function getCategorySchema(): array
    {
        return [
            TextEntry::make('category.name')
                ->label('Name'),
        ];
    }

    public static function getParentSchema(): array
    {
        return [
            TextEntry::make('parent.name')
                ->label('Name'),
        ];
    }

    public static function getSettingsSchema(): array
    {
        return [
            EnabledIconEntry::make(),
        ];
    }
}
