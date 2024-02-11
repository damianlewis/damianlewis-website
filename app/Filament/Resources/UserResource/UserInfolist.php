<?php

namespace App\Filament\Resources\UserResource;

use App\Enums\MediaCollection;
use App\Enums\MediaConversion;
use App\Filament\Infolists\Components\DatesSection;
use App\Filament\Infolists\Components\DateTimeTextEntry;
use App\Models\User;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontFamily;

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
                        self::getStatuesDatesSection(),
                        self::getAvatarSection(),
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

    public static function getStatuesDatesSection(): Section
    {
        return Section::make('Status')
            ->schema(self::getStatuesDatesSchema())
            ->columns()
            ->visible(fn (User $record): bool => $record->isBlocked());
    }

    public static function getAvatarSection(): Section
    {
        return Section::make('Avatar')
            ->schema(self::getAvatarSchema());
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
                ->fontFamily(FontFamily::Mono)
                ->copyable(),
        ];
    }

    public static function getStatuesDatesSchema(): array
    {
        return [
            DateTimeTextEntry::make('blocked_at')
                ->label('Blocked')
                ->visible(fn (User $record): bool => $record->isBlocked()),

        ];
    }

    public static function getAvatarSchema(): array
    {
        return [
            SpatieMediaLibraryImageEntry::make('avatar')
                ->hiddenLabel()
                ->extraImgAttributes(fn (User $record): array => [
                    'alt' => "{$record->name} avatar",
                ])
                ->collection(MediaCollection::AvatarImages->value)
                ->conversion(MediaConversion::Thumbnail->value)
                ->circular(),
        ];
    }

    public static function getRolesSchema(): array
    {
        return [
            TextEntry::make('roles.display_name')
                ->hiddenLabel()
                ->badge(),
        ];
    }
}
