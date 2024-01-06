<?php

namespace App\Filament\Resources\TechnologyResource;

use App\Filament\Forms\Components\Actions\GenerateFormDataAction;
use App\Filament\Forms\Components\DatesSection;
use App\Filament\Forms\Components\EnabledToggle;
use App\Filament\Forms\ResourceForm;
use App\Filament\Resources\TechnologyCategoryResource;
use App\Filament\Resources\TechnologyCategoryResource\RelationManagers\TechnologiesRelationManager;
use App\Filament\Resources\TechnologyCategoryResource\TechnologyCategoryForm;
use App\Models\Technology;
use App\Models\TechnologyCategory;
use Closure;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Exists;

class TechnologyForm extends ResourceForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        self::getCategorySection()
                            ->hiddenOn(TechnologiesRelationManager::class),
                        self::getDetailsSection(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        DatesSection::make(),
                        self::getParentSection()
                            ->hidden(
                                fn (?Technology $record): bool => (bool) $record?->hasChildren()
                            ),
                        self::getSettingsSection(),
                    ])
                    ->columnSpan(['lg' => 1]),
                Actions::make(
                    self::generateFormDataAction($form)
                ),
            ])
            ->columns(3);
    }

    public static function getCategorySection(): Section
    {
        return Section::make('Category')
            ->schema(
                self::getCategorySchema()
            );
    }

    public static function getDetailsSection(): Section
    {
        return Section::make('Details')
            ->schema(
                self::getDetailsSchema()
            );
    }

    public static function getParentSection(): Section
    {
        return Section::make('Parent')
            ->schema(
                self::getParentSchema()
            );
    }

    public static function getSettingsSection(): Section
    {
        return Section::make('Settings')
            ->schema(
                self::getSettingsSchema()
            );
    }

    public static function getCategorySchema(): array
    {
        return [
            Select::make('technology_category_id')
                ->hiddenLabel()
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->createOptionForm([
                    Grid::make(3)
                        ->schema([
                            Group::make()
                                ->schema([
                                    TechnologyCategoryForm::getDetailsSection(),
                                ])
                                ->columnSpan(['lg' => 2]),
                            Group::make()
                                ->schema([
                                    TechnologyCategoryForm::getSettingsSection(),
                                ])
                                ->columnSpan(['lg' => 1]),
                        ]),
                ])
                ->createOptionModalHeading(
                    __('filament-panels::resources/pages/create-record.title', [
                        'label' => Str::headline(TechnologyCategoryResource::getModelLabel()),
                    ])
                )
                ->createOptionAction(
                    fn (Action $action): Action => $action->modalWidth(MaxWidth::FiveExtraLarge)
                )
                ->live()
                ->afterStateUpdated(
                    fn (Set $set) => $set('parent_id', null)
                )
                ->required()
                ->exists(
                    TechnologyCategory::class,
                    (new TechnologyCategory)->getKeyName(),
                ),
        ];
    }

    public static function getDetailsSchema(): array
    {
        return [
            TextInput::make('name')
                ->autocapitalize('words')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(
                    function (
                        Get $get,
                        Set $set,
                        ?string $old,
                        ?string $state,
                    ): void {
                        if (($get('slug') ?? '') !== Str::slug($old)) {
                            return;
                        }

                        $set('slug', Str::slug($state));
                    }
                ),
            TextInput::make('slug')
                ->required()
                ->rule('alpha_dash')
                ->maxLength(255)
                ->unique(ignoreRecord: true),
        ];
    }

    private static function getParentSchema(): array
    {
        $technology = new Technology();

        return [
            Select::make('parent_id')
                ->hiddenLabel()
                ->relationship(
                    name: 'parent',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn (
                        Builder $query,
                        ?Technology $record,
                        Get $get,
                    ): Builder => $query
                        ->whereNull('parent_id')
                        ->whereNot($technology->getKeyName(), $record?->getKey())
                        ->where('technology_category_id', $get('technology_category_id'))
                )
                ->searchable()
                ->preload()
                ->nullable()
                ->exists(
                    column: $technology->getKeyName(),
                    modifyRuleUsing: fn (
                        Exists $rule,
                        ?Technology $record,
                        Get $get,
                    ): Exists => $rule
                        ->whereNull('parent_id')
                        ->whereNot($technology->getKeyName(), $record?->getKey())
                        ->where('technology_category_id', $get('technology_category_id'))
                )
                ->rule(
                    fn (?Technology $record): Closure => static fn (
                        string $attribute,
                        string $value,
                        Closure $fail
                    ): ?string => $record?->hasChildren()
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

    public static function generateFormDataAction(Form $form): array
    {
        return [
            GenerateFormDataAction::makeFor(
                form: $form,
                data: Technology::factory()
                    ->make()
                    ->makeVisible('password')
                    ->toArray(),
            ),
        ];
    }
}
