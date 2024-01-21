<?php

namespace App\Filament\Resources\UserResource;

use App\Filament\Infolists\Components\DatesSection;
use App\Models\User;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class UserInfolist
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
                        self::getRolesSection(),
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

    public static function getRolesSection(): Section
    {
        return Section::make('Roles')
            ->schema(self::getRolesSchema())
            ->visible(
                fn (User $record): bool => $record->roles()->exists()
            );
    }

    public static function getDetailsSchema(): array
    {
        return [
            TextEntry::make('name'),
            TextEntry::make('email')
                ->copyable(),
        ];
    }

    public static function getRolesSchema(): array
    {
        return [
            TextEntry::make('roles.display_name')
                ->label('Name')
                ->hiddenLabel(fn (User $record): bool => $record->hasAnyRole())
                ->default('No roles assigned'),
        ];
    }
}
