<?php

namespace App\Filament\Resources\TechnologyResource;

use App\Filament\Tables\Actions\DisableBulkAction;
use App\Filament\Tables\Actions\EnableBulkAction;
use App\Filament\Tables\Columns\CreatedAtTextColumn;
use App\Filament\Tables\Columns\DeletedAtTextColumn;
use App\Filament\Tables\Columns\EnabledIconColumn;
use App\Filament\Tables\Columns\NameTextColumn;
use App\Filament\Tables\Columns\SlugTextColumn;
use App\Filament\Tables\Columns\UpdatedAtTextColumn;
use App\Filament\Tables\Filters\EnabledFilter;
use App\Filament\Tables\ResourceTable;
use App\Models\Technology;
use Exception;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TechnologyTable extends ResourceTable
{
    /**
     * @throws Exception
     */
    public static function make(Table $table): Table
    {
        return parent::make($table)
            ->columns([
                NameTextColumn::make(),
                SlugTextColumn::make(),
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
                DeletedAtTextColumn::make(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('parent')
                    ->relationship('parent', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                EnabledFilter::make(),
                TrashedFilter::make()
                    ->native(false),
            ])
            ->persistFiltersInSession()
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
            ]);
    }
}
