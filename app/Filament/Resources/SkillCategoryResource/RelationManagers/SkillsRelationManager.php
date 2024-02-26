<?php

namespace App\Filament\Resources\SkillCategoryResource\RelationManagers;

use App\Filament\Resources\SkillResource;
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
use App\Models\Skill;
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

class SkillsRelationManager extends RelationManager
{
    protected static string $relationship = 'skills';

    public function infolist(Infolist $infolist): Infolist
    {
        return SkillResource::infolist($infolist);
    }

    public function form(Form $form): Form
    {
        return SkillResource::form($form);
    }

    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        $isViewPage = is_subclass_of($this->getPageClass(), ViewRecord::class);

        return ResourceTable::make($table)
            ->recordTitleAttribute('name')
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
                    ->url(fn (Skill $record): string => SkillResource::getUrl(
                        'edit',
                        [
                            'record' => $record,
                        ]
                    ))
                    ->hidden(
                        fn (Skill $record): bool => $record->trashed()
                    ),
                DeleteAction::make(),
            ])
            ->bulkActions($isViewPage ? [] : [
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
                fn (RelationManager $livewire, Table $table): bool => ! $isViewPage
            )
            ->defaultSort(config('eloquent-sortable.order_column_name'));
    }
}
