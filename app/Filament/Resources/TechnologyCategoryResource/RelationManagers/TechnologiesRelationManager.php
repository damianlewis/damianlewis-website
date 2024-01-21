<?php

namespace App\Filament\Resources\TechnologyCategoryResource\RelationManagers;

use App\Filament\Resources\TechnologyResource;
use App\Filament\Tables\Actions\DisableBulkAction;
use App\Filament\Tables\Actions\EnableBulkAction;
use App\Filament\Tables\Columns\CreatedAtTextColumn;
use App\Filament\Tables\Columns\DeletedAtTextColumn;
use App\Filament\Tables\Columns\EnabledIconColumn;
use App\Filament\Tables\Columns\NameTextColumn;
use App\Filament\Tables\Columns\SlugTextColumn;
use App\Filament\Tables\Columns\SortOrderTextColumn;
use App\Filament\Tables\Columns\UpdatedAtTextColumn;
use App\Filament\Tables\Filters\EnabledFilter;
use App\Filament\Tables\ResourceTable;
use App\Models\Technology;
use Exception;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TechnologiesRelationManager extends RelationManager
{
    protected static string $relationship = 'technologies';

    public function infolist(Infolist $infolist): Infolist
    {
        return TechnologyResource::infolist($infolist);
    }

    public function form(Form $form): Form
    {
        return TechnologyResource::form($form);
    }

    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return ResourceTable::make($table)
            ->columns([
                NameTextColumn::make(),
                SlugTextColumn::make(),
                TextColumn::make('parent.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                EnabledIconColumn::make(),
                SortOrderTextColumn::make(),
                CreatedAtTextColumn::make(),
                UpdatedAtTextColumn::make(),
                DeletedAtTextColumn::make(),
            ])
            ->filters([
                SelectFilter::make('parent')
                    ->relationship('parent', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                EnabledFilter::make(),
                TrashedFilter::make()
                    ->native(false),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                    ->hidden(
                        fn (Technology $record): bool => $record->trashed()
                    ),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    EnableBulkAction::make(),
                    DisableBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->reorderable(
                config('eloquent-sortable.order_column_name'),
                fn (RelationManager $livewire, Table $table): bool => ! is_subclass_of($this->getPageClass(), ViewRecord::class)
            )
            ->defaultSort(config('eloquent-sortable.order_column_name'));
    }
}
