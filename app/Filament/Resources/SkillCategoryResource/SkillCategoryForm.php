<?php

namespace App\Filament\Resources\SkillCategoryResource;

use App\Filament\Forms\Components\Actions\GenerateFormDataAction;
use App\Filament\Forms\Components\DatesSection;
use App\Filament\Forms\Components\EnabledToggle;
use App\Filament\Forms\Components\NameTextInput;
use App\Filament\Forms\Components\SimpleRichEditor;
use App\Filament\Forms\Components\SlugTextInput;
use App\Filament\Forms\ResourceForm;
use App\Models\SkillCategory;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;

class SkillCategoryForm extends ResourceForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                ...self::getFormSchema(),
                Actions::make(self::getFormActions($form)),
            ])
            ->columns(3);
    }

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
                    self::getSettingsSection(),
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

    public static function getSettingsSection(): Section
    {
        return Section::make('Settings')
            ->description(self::help())
            ->schema(self::getSettingsSchema());
    }

    public static function getDetailsSchema(): array
    {
        return [
            NameTextInput::forSlug()
                ->autofocus(
                    fn (string $operation): bool => $operation === 'create'
                )
                ->autocapitalize('words'),
            SlugTextInput::make(),
            SimpleRichEditor::make('description')
                ->nullable()
                ->string(),
        ];
    }

    public static function getSettingsSchema(): array
    {
        return [
            EnabledToggle::make(),
        ];
    }

    public static function getFormActions(Form $form): array
    {
        return [
            GenerateFormDataAction::makeFor(
                form: $form,
                data: SkillCategory::factory()
                    ->make()
                    ->toArray(),
            ),
        ];
    }
}
