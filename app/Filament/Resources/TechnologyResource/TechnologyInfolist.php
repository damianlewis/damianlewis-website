<?php

namespace App\Filament\Resources\TechnologyResource;

use App\Filament\Infolists\Components\DatesSection;
use App\Filament\Infolists\Components\EnabledIconEntry;
use App\Models\Technology;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class TechnologyInfolist
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
                        Section::make('Category')
                            ->schema(
                                self::getCategorySchema(),
                            )
                            ->visible(fn (Technology $record) => $record->hasCategory()),
                        Section::make('Parent')
                            ->schema(
                                self::getParentSchema(),
                            ),
                        Section::make('Settings')
                            ->schema(
                                self::getSettingsSchema(),
                            ),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function getDetailsSchema(): array
    {
        return [
            TextEntry::make('name')
                ->color('gray'),
            TextEntry::make('slug')
                ->color('gray'),
        ];
    }

    public static function getCategorySchema(): array
    {
        return [
            TextEntry::make('category.name')
                ->color('gray'),
        ];
    }

    public static function getParentSchema(): array
    {
        return [
            TextEntry::make('parent.name')
                ->color('gray')
                ->visible(fn (Technology $record) => $record->hasParent()),
        ];
    }

    public static function getSettingsSchema(): array
    {
        return [
            EnabledIconEntry::make(),
        ];
    }
}
