<?php

namespace App\Filament\Resources\TechnologyCategoryResource;

use App\Filament\Tables\Columns\CreatedAtTextColumn;
use App\Filament\Tables\Columns\DeletedAtTextColumn;
use App\Filament\Tables\Columns\EnabledIconColumn;
use App\Filament\Tables\Columns\SortOrderTextColumn;
use App\Filament\Tables\Columns\UpdatedAtTextColumn;
use App\Filament\Tables\Filters\EnabledFilter;
use App\Models\TechnologyCategory;
use Exception;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TechnologyCategoryTable
{
    /**
     * @throws Exception
     */
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
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
                EnabledFilter::make(),
                TrashedFilter::make()
                    ->native(false),
            ])
            ->actions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton()
                    ->hidden(fn (TechnologyCategory $record): bool => $record->trashed()),
                DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable(config('eloquent-sortable.order_column_name'))
            ->defaultSort(config('eloquent-sortable.order_column_name'));
    }
}
