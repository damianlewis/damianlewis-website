<?php

namespace App\Filament\Resources\TechnologyResource;

use App\Filament\Resources\TechnologyCategoryResource\RelationManagers\TechnologiesRelationManager;
use App\Filament\Tables\Columns\CreatedAtTextColumn;
use App\Filament\Tables\Columns\DeletedAtTextColumn;
use App\Filament\Tables\Columns\EnabledIconColumn;
use App\Filament\Tables\Columns\UpdatedAtTextColumn;
use App\Filament\Tables\Filters\EnabledFilter;
use App\Models\Technology;
use App\Models\TechnologyCategory;
use Exception;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class TechnologyTable
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
                    ->preload()
                    ->hiddenOn(TechnologiesRelationManager::class),
                SelectFilter::make('parent')
                    ->relationship('parent', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                EnabledFilter::make(),
                TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton()
                    ->hidden(fn (Technology $record): bool => $record->trashed()),
                DeleteAction::make()
                    ->iconButton()
                    ->before(function (Technology $record) {
                        if ($record->hasChildren()) {
                            $record->children->each(fn (Technology $child) => $child->update(['parent_id' => null]));
                        }
                    }),
                RestoreAction::make()
                    ->iconButton()
                    ->form(function (Technology $record): ?array {
                        if ($record->category()->doesntExist()) {
                            return [
                                Select::make('technology_category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->exists(TechnologyCategory::class, (new TechnologyCategory)->getKeyName()),
                            ];
                        }

                        return null;
                    })
                    ->before(function (Technology $record) {
                        if ($record->parent()->doesntExist() && $record->parent_id !== null) {
                            $record->parent_id = null;
                        }

                        if ($record->parent()->exists() && $record->parent->technology_category_id !== $record->technology_category_id) {
                            $record->parent_id = null;
                        }
                        //                        if ($record->parent()->exists() && $record->parent->technology_category_id !== $record->technology_category_id) {
                        //                            $record->parent()->dissociate();
                        //                            $record->save();
                        //                        }
                    }),
                ForceDeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->after(function (Collection $records) {
                            $records->each(function (Technology $record) {
                                if ($record->hasChildren()) {
                                    $record->children->each(fn (Technology $child) => $child->update(['parent_id' => null]));
                                }
                            });
                        }),
                    //                    RestoreBulkAction::make()
                    //                        ->before(function (Collection $records) {
                    //                            $records->each(function (Technology $record) {
                    //                                if ($record->category()->doesntExist() && $record->technology_category_id !== null) {
                    //                                    $record->technology_category_id = null;
                    //                                }
                    //                            });
                    //                        }),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
