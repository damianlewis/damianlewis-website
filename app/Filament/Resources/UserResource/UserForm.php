<?php

namespace App\Filament\Resources\UserResource;

use App\Enums\Disk;
use App\Enums\MediaCollection;
use App\Filament\Forms\Components\Actions\GenerateFormDataAction;
use App\Filament\Forms\Components\DatesSection;
use App\Filament\Forms\Components\DateTimePlaceholder;
use App\Filament\Forms\Components\NameTextInput;
use App\Filament\Forms\ResourceForm;
use App\Models\Role;
use App\Models\User;
use Exception;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Validation\Rules\Password;

class UserForm extends ResourceForm
{
    /**
     * @throws Exception
     */
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                ...self::getFormSchema(),
                Actions::make(self::getFormActions($form)),
            ])
            ->columns(3);
    }

    /**
     * @throws Exception
     */
    public static function getFormSchema(): array
    {
        return [
            Group::make()
                ->schema([
                    self::getDetailsSection(),
                ])
                ->columnSpan(['lg' => 2]),
            Group::make()
                ->schema([
                    DatesSection::make(),
                    self::getStatusDatesSection(),
                    self::getAvatarSection(),
                    self::getRolesSection(),
                ])
                ->columnSpan(['lg' => 1]),
        ];
    }

    public static function getDetailsSection(): Section
    {
        return Section::make('Details')
            ->description(self::help())
            ->schema(self::getDetailsSchema());
    }

    public static function getStatusDatesSection(): Section
    {
        return Section::make('Status')
            ->description(self::help())
            ->schema(self::getStatuesDatesSchema())
            ->columns()
            ->hiddenOn('create')
            ->visible(fn (User $record) => $record->isBlocked());
    }

    /**
     * @throws Exception
     */
    public static function getAvatarSection(): Section
    {
        return Section::make('Avatar')
            ->description(self::help())
            ->schema(self::getAvatarSchema());
    }

    public static function getRolesSection(): Section
    {
        return Section::make('Roles')
            ->description(self::help())
            ->schema(self::getRolesSchema());
    }

    public static function getDetailsSchema(): array
    {
        return [
            NameTextInput::make()
                ->autofocus(
                    fn (string $operation): bool => $operation === 'create'
                ),
            TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
            TextInput::make('password')
                ->password()
                ->revealable()
                ->autocomplete(false)
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->required(
                    fn (string $operation): bool => $operation === 'create'
                )
                ->maxLength(255)
                ->rule(Password::defaults())
                ->confirmed()
                ->live(),
            TextInput::make('password_confirmation')
                ->password()
                ->revealable()
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->hidden(fn (Get $get): bool => empty($get('password'))),
        ];
    }

    public static function getStatuesDatesSchema(): array
    {
        return [
            DateTimePlaceholder::make('blocked_at')
                ->label('Blocked')
                ->visible(fn (User $record) => $record->isBlocked()),
        ];
    }

    /**
     * @throws Exception
     */
    public static function getAvatarSchema(): array
    {
        return [
            SpatieMediaLibraryFileUpload::make('avatar')
                ->hiddenLabel()
                ->disk(Disk::AvatarImages->value)
                ->collection(MediaCollection::AvatarImages->value)
                ->avatar()
                ->imageEditor()
                ->imageEditorMode(2)
                ->maxSize(1024),
        ];
    }

    public static function getRolesSchema(): array
    {
        return [
            Select::make('roles')
                ->hiddenLabel()
                ->relationship('roles', 'display_name')
                ->multiple()
                ->preload()
                ->searchable()
                ->nullable()
                ->exists(Role::class, (new Role)->getKeyName()),
        ];
    }

    public static function getFormActions(Form $form): array
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
