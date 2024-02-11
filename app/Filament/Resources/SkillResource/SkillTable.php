<?php

namespace App\Filament\Resources\SkillResource;

use App\Filament\Resources\SkillCategoryResource;
use App\Filament\Resources\SkillResource;
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
use App\Models\Skill;
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
use Illuminate\Database\Eloquent\Builder;

class SkillTable extends ResourceTable
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
                    ->color('primary')
                    ->url(fn (Skill $record): ?string => $record->hasParent()
                        ? SkillResource::getUrl(
                            'view',
                            [
                                'record' => $record->parent,
                            ]
                        )
                        : null
                    )
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('category.name')
                    ->color('primary')
                    ->url(
                        fn (Skill $record): string => SkillCategoryResource::getUrl(
                            'view',
                            [
                                'record' => $record->category,
                            ]
                        )
                    )
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
                    ->relationship(
                        name: 'parent',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query): Builder => $query->whereHas('children')
                    )
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
                        fn (Skill $record): bool => $record->trashed()
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
