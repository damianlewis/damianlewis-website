<?php

namespace App\Filament\Resources\SkillResource;

use App\Filament\Forms\Components\Actions\GenerateFormDataAction;
use App\Filament\Forms\Components\DatesSection;
use App\Filament\Forms\Components\EnabledToggle;
use App\Filament\Forms\Components\NameTextInput;
use App\Filament\Forms\Components\SlugTextInput;
use App\Filament\Forms\ResourceForm;
use App\Filament\Resources\SkillCategoryResource;
use App\Filament\Resources\SkillCategoryResource\SkillCategoryForm;
use App\Models\Skill;
use App\Models\SkillCategory;
use Closure;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Exists;

class SkillForm extends ResourceForm
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
                    self::getCategorySection(),
                    self::getDetailsSection(),
                ])
                ->columnSpan(['lg' => 2]),
            Group::make()
                ->schema([
                    DatesSection::make(),
                    self::getParentSection(),
                    self::getSettingsSection(),
                ])
                ->columnSpan(['lg' => 1]),
        ];
    }

    public static function getCategorySection(): Section
    {
        return Section::make('Category')
            ->description(self::help())
            ->schema(self::getCategorySchema());
    }

    public static function getDetailsSection(): Section
    {
        return Section::make('Details')
            ->description(self::help())
            ->schema(self::getDetailsSchema());
    }

    public static function getParentSection(): Section
    {
        return Section::make('Parent')
            ->description(self::help())
            ->schema(self::getParentSchema())
            ->hidden(
                fn (?Skill $record): bool => (bool) $record?->hasChildren()
            );
    }

    public static function getSettingsSection(): Section
    {
        return Section::make('Settings')
            ->description(self::help())
            ->schema(self::getSettingsSchema());
    }

    public static function getCategorySchema(): array
    {
        $skill = new Skill();
        $categoryForeignKeyName = $skill->category()->getForeignKeyName();
        $parentForeignKeyName = $skill->parent()->getForeignKeyName();

        return [
            Select::make($categoryForeignKeyName)
                ->hiddenLabel()
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->createOptionForm(fn (Form $form) => [
                    Grid::make(3)
                        ->schema([
                            ...SkillCategoryForm::getFormSchema(),
                            Actions::make(SkillCategoryForm::getFormActions($form)),
                        ]),
                ])
                ->createOptionModalHeading(
                    __('filament-panels::resources/pages/create-record.title', [
                        'label' => Str::headline(SkillCategoryResource::getModelLabel()),
                    ])
                )
                ->createOptionAction(
                    fn (Action $action): Action => $action
                        ->modalWidth(MaxWidth::FiveExtraLarge)
                )
                ->live()
                ->afterStateUpdated(
                    fn (Set $set) => $set($parentForeignKeyName, null)
                )
                ->required()
                ->exists(
                    SkillCategory::class,
                    (new SkillCategory)->getKeyName(),
                ),
        ];
    }

    public static function getDetailsSchema(): array
    {
        return [
            NameTextInput::forSlug()
                ->autocapitalize('words'),
            SlugTextInput::make(),
        ];
    }

    private static function getParentSchema(): array
    {
        $skill = new Skill();
        $parentForeignKeyName = $skill->parent()->getForeignKeyName();
        $categoryForeignKeyName = (new Skill)->category()->getForeignKeyName();

        return [
            Select::make($parentForeignKeyName)
                ->hiddenLabel()
                ->relationship(
                    name: 'parent',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn (Builder $query, ?Skill $record, Get $get): Builder => $query
                        ->whereNull($parentForeignKeyName)
                        ->where(
                            $categoryForeignKeyName,
                            $get($categoryForeignKeyName)
                        ),
                    ignoreRecord: true
                )
                ->searchable()
                ->preload()
                ->nullable()
                ->exists(
                    column: $skill->getKeyName(),
                    modifyRuleUsing: fn (Exists $rule, ?Skill $record, Get $get): Exists => $rule
                        ->whereNull($parentForeignKeyName)
                        ->whereNot(
                            $skill->getKeyName(),
                            $record?->getKey()
                        )
                        ->where(
                            $categoryForeignKeyName,
                            $get($categoryForeignKeyName)
                        )
                )
                ->rule(
                    fn (?Skill $record): Closure => static fn (string $attribute, string $value, Closure $fail): ?string => $record?->hasChildren()
                        ? $fail($record->name . ' can\'t have a parent as it is already a parent')
                        : null
                ),
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
                data: Skill::factory()
                    ->make()
                    ->makeVisible('password')
                    ->toArray(),
            ),
        ];
    }
}
