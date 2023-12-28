<?php

namespace App\Filament\Resources\TechnologyCategoryResource;

use App\Filament\Forms\Components\DatesSection;
use App\Filament\Forms\Components\EnabledToggle;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class TechnologyCategoryForm
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
            TextInput::make('name')
                ->autofocus(fn (string $operation): bool => $operation === 'create')
                ->autocapitalize('words')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state): void {
                    if (($get('slug') ?? '') !== Str::slug($old)) {
                        return;
                    }

                    $set('slug', Str::slug($state));
                }),
            TextInput::make('slug')
                ->required()
                ->rule('alpha_dash')
                ->maxLength(255)
                ->unique(ignoreRecord: true),
            RichEditor::make('description')
                ->disableToolbarButtons([
                    'attachFiles',
                    'blockquote',
                    'codeBlock',
                ])
                ->nullable()
                ->maxLength(65535),

        ];
    }

    public static function getSettingsSchema(): array
    {
        return [
            EnabledToggle::make(),
        ];
    }
}
