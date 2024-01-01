<?php

namespace App\Filament\Resources\UserResource;

use App\Filament\Forms\Components\Actions\GenerateFormDataAction;
use App\Filament\Forms\Components\DatesSection;
use App\Models\User;
use Filament\Forms\Components\Actions;
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
                        self::getDetailsSection(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        DatesSection::make(),
                        self::getRolesSection(),
                    ])
                    ->columnSpan(['lg' => 1]),
                Actions::make(
                    self::generateFormDataAction($form)
                ),
            ])
            ->columns(3);
    }

    public static function getDetailsSection(): Section
    {
        return Section::make('Details')
            ->schema(
                self::getDetailsSchema()
            );
    }

    public static function getRolesSection(): Section
    {
        return Section::make('Roles')
            ->schema(
                self::getRolesSchema()
            );
    }

    public static function getDetailsSchema(): array
    {
        return [
            TextInput::make('name')
                ->autofocus(fn (string $operation): bool => $operation === 'create')
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

    public static function getRolesSchema(): array
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

    public static function generateFormDataAction(Form $form): array
    {
        return [
            GenerateFormDataAction::makeFor(
                form: $form,
                data: [
                    ...User::factory()
                        ->unverified()
                        ->make()
                        ->toArray(),
                    'password' => 'secret',
                    'password_confirmation' => 'secret',
                ],
            ),
        ];
    }
}
