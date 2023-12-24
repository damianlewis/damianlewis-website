<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\EnabledSection;
use App\Filament\Forms\Components\TimestampsSection;
use App\Filament\Resources\TechnologyCategoryResource\Pages\CreateTechnologyCategory;
use App\Filament\Resources\TechnologyCategoryResource\Pages\EditTechnologyCategory;
use App\Filament\Resources\TechnologyCategoryResource\Pages\ListTechnologyCategories;
use App\Filament\Resources\TechnologyCategoryResource\Pages\ViewTechnologyCategory;
use App\Filament\Resources\TechnologyCategoryResource\RelationManagers\TechnologiesRelationManager;
use App\Filament\Tables\Columns\CreatedAtTextColumn;
use App\Filament\Tables\Columns\EnabledIconColumn;
use App\Filament\Tables\Columns\SortOrderTextColumn;
use App\Filament\Tables\Columns\UpdatedAtTextColumn;
use App\Filament\Tables\Filters\EnabledFilter;
use App\Models\TechnologyCategory;
use Exception;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TechnologyCategoryResource extends Resource
{
    protected static ?string $model = TechnologyCategory::class;

    protected static ?string $navigationGroup = 'Technology';

    protected static ?string $navigationLabel = 'Categories';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'md' => 3,
                ])
                    ->schema([
                        Section::make('Details')
                            ->schema([
                                TextInput::make('name')
                                    ->autocapitalize('words')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                RichEditor::make('description')
                                    ->disableToolbarButtons([
                                        'attachFiles',
                                        'blockquote',
                                        'codeBlock',
                                    ])
                                    ->nullable()
                                    ->maxLength(65535),
                            ])
                            ->columnSpan([
                                'md' => 2,
                            ]),
                        Group::make()
                            ->schema([
                                TimestampsSection::make(),
                                EnabledSection::make(),
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
                EnabledIconColumn::make(),
                SortOrderTextColumn::make(),
                CreatedAtTextColumn::make(),
                UpdatedAtTextColumn::make(),
            ])
            ->filters([
                EnabledFilter::make(),
                TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton()
                    ->hidden(fn (TechnologyCategory $record): bool => $record->trashed()),
                DeleteAction::make()
                    ->iconButton(),
                RestoreAction::make()
                    ->iconButton(),
                ForceDeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->reorderable(config('eloquent-sortable.order_column_name'))
            ->defaultSort(config('eloquent-sortable.order_column_name'));
    }

    public static function getRelations(): array
    {
        return [
            TechnologiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTechnologyCategories::route('/'),
            'create' => CreateTechnologyCategory::route('/create'),
            'view' => ViewTechnologyCategory::route('/{record}'),
            'edit' => EditTechnologyCategory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
