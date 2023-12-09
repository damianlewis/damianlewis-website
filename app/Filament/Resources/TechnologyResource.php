<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\EnabledSection;
use App\Filament\Forms\Components\TimestampsSection;
use App\Filament\Infolists\Components\EnabledSection as InfolistEnabledSection;
use App\Filament\Infolists\Components\TimestampsSection as InfolistTimestampsSection;
use App\Filament\Resources\TechnologyCategoryResource\RelationManagers\TechnologiesRelationManager;
use App\Filament\Resources\TechnologyResource\Pages\CreateTechnology;
use App\Filament\Resources\TechnologyResource\Pages\EditTechnology;
use App\Filament\Resources\TechnologyResource\Pages\ListTechnologies;
use App\Filament\Tables\Columns\CreatedAtTextColumn;
use App\Filament\Tables\Columns\EnabledIconColumn;
use App\Filament\Tables\Columns\UpdatedAtTextColumn;
use App\Filament\Tables\Filters\EnabledFilter;
use App\Models\Technology;
use App\Models\TechnologyCategory;
use Closure;
use Exception;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Grid as InfolistGrid;
use Filament\Infolists\Components\Group as InfolistGroup;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Exists;

class TechnologyResource extends Resource
{
    protected static ?string $model = Technology::class;

    protected static ?string $navigationGroup = 'Technology';

    protected static ?string $recordTitleAttribute = 'name';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistGrid::make([
                    'md' => 3,
                ])
                    ->schema([
                        InfolistGroup::make()
                            ->schema([
                                InfolistSection::make('Details')
                                    ->schema([
                                        TextEntry::make('name')
                                            ->color('gray'),
                                        TextEntry::make('category.name')
                                            ->color('gray'),
                                        TextEntry::make('parent.name')
                                            ->color('gray')
                                            ->visible(fn (Technology $record) => $record->hasParent()),
                                    ]),
                            ])
                            ->columnSpan([
                                'md' => 2,
                            ]),
                        InfolistGroup::make()
                            ->schema([
                                InfolistTimestampsSection::make(),
                                InfolistEnabledSection::make(),
                            ])
                            ->columnSpan([
                                'md' => 1,
                            ]),
                    ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'md' => 3,
                ])
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make('Category')
                                    ->schema([
                                        Select::make('technology_category_id')
                                            ->label(false)
                                            ->relationship('category', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->live()
                                            ->afterStateUpdated(fn (Set $set) => $set('parent_id', null))
                                            ->required()
                                            ->exists(TechnologyCategory::class, (new TechnologyCategory)->getKeyName()),
                                    ]),
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
                                                modifyQueryUsing: fn (Builder $query, ?Technology $record, Get $get): Builder => $query
                                                    ->whereNull('parent_id')
                                                    ->whereNot((new static::$model)->getKeyName(), $record?->getKey())
                                                    ->where('technology_category_id', $get('technology_category_id'))
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->nullable()
                                            ->exists(
                                                column: (new static::$model)->getKeyName(),
                                                modifyRuleUsing: fn (Exists $rule, ?Technology $record, Get $get): Exists => $rule
                                                    ->whereNull('parent_id')
                                                    ->whereNot((new static::$model)->getKeyName(), $record?->getKey())
                                                    ->where('technology_category_id', $get('technology_category_id'))
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
    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('parent.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('category.name')
                    ->sortable()
                    ->searchable(),
                EnabledIconColumn::make(),
                CreatedAtTextColumn::make(),
                UpdatedAtTextColumn::make(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->hiddenOn(TechnologiesRelationManager::class),
                SelectFilter::make('parent')
                    ->relationship('parent', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                EnabledFilter::make(),
            ])
            ->actions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTechnologies::route('/'),
            'create' => CreateTechnology::route('/create'),
            'edit' => EditTechnology::route('/{record}/edit'),
        ];
    }
}
