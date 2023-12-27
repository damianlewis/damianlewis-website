<?php

namespace App\Filament\Resources\UserResource;

use App\Filament\Forms\Components\DatesSection;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function make(Form $form): Form
    {
        return $form
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
                        Section::make('Roles')
                            ->schema(
                                self::getRolesSchema()
                            ),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    private static function getDetailsSchema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
            TextInput::make('password')
                ->password()
                ->autocomplete(false)
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->required(fn (string $operation): bool => $operation === 'create')
                ->maxLength(255)
                ->rule(Password::defaults())
                ->confirmed()
                ->live(),
            TextInput::make('password_confirmation')
                ->password()
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->hidden(fn (Get $get): bool => empty($get('password'))),
        ];
    }

    private static function getRolesSchema(): array
    {
        return [
            Select::make('roles')
                ->label('Name')
                ->relationship('roles', 'display_name')
                ->multiple()
                ->preload()
                ->searchable(),
        ];
    }
}
