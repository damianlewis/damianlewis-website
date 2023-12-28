<?php

namespace App\Filament\Resources\TechnologyCategoryResource\RelationManagers;

use App\Filament\Forms\Components\EnabledSection;
use App\Filament\Forms\Components\TimestampsSection;
use App\Filament\Resources\TechnologyResource;
use App\Filament\Tables\Columns\CreatedAtTextColumn;
use App\Filament\Tables\Columns\DeletedAtTextColumn;
use App\Filament\Tables\Columns\EnabledIconColumn;
use App\Filament\Tables\Columns\SortOrderTextColumn;
use App\Filament\Tables\Columns\UpdatedAtTextColumn;
use App\Models\Technology;
use Closure;
use Exception;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Exists;

class TechnologiesRelationManager extends RelationManager
{
    protected static string $relationship = 'technologies';

    public function infolist(Infolist $infolist): Infolist
    {
        return TechnologyResource::infolist($infolist);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'md' => 3,
                ])
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make('Details')
                                    ->schema([
                                        TextInput::make('name')
                                            ->autocapitalize('words')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255),
                                    ]),
                            ])
                            ->columnSpan([
                                'md' => 2,
                            ]),
                        Group::make()
                            ->schema([
                                TimestampsSection::make(),
                                EnabledSection::make(),
                                Section::make()
                                    ->schema([
                                        Select::make('parent_id')
                                            ->relationship(
                                                name: 'parent',
                                                titleAttribute: 'name',
                                                modifyQueryUsing: fn (Builder $query, ?Technology $record, RelationManager $livewire): Builder => $query
                                                    ->whereNull('parent_id')
                                                    ->whereNot((new Technology)->getKeyName(), $record?->getKey())
                                                    ->where('technology_category_id', $livewire->getOwnerRecord()->getKey())
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->nullable()
                                            ->exists(
                                                column: (new Technology)->getKeyName(),
                                                modifyRuleUsing: fn (Exists $rule, ?Technology $record, RelationManager $livewire): Exists => $rule
                                                    ->whereNull('parent_id')
                                                    ->whereNot((new Technology)->getKeyName(), $record?->getKey())
                                                    ->where('technology_category_id', $livewire->getOwnerRecord()->getKey())
                                            )
                                            ->rule(fn (?Technology $record): Closure => static fn (string $attribute, string $value, Closure $fail): ?string => $record?->hasChildren()
                                                ? $fail($record->name . ' can\'t have a parent as it is already a parent')
                                                : null
                                            ),
                                    ])
                                    ->hidden(fn (?Technology $record) => $record?->hasChildren()),
                            ])
                            ->columnSpan([
                                'md' => 1,
                            ]),
                    ]),
            ]);
    }

    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return TechnologyResource::table($table)
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('parent.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('category.name')
                    ->sortable()
                    ->searchable(),
                EnabledIconColumn::make(),
                SortOrderTextColumn::make(),
                CreatedAtTextColumn::make(),
                UpdatedAtTextColumn::make(),
                DeletedAtTextColumn::make(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->reorderable(config('eloquent-sortable.order_column_name'))
            ->defaultSort(config('eloquent-sortable.order_column_name'));
    }
}
