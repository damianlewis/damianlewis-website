<?php

namespace App\Filament\Resources\TechnologyCategoryResource\RelationManagers;

use App\Filament\Resources\TechnologyResource;
use App\Filament\Tables\Columns\CreatedAtTextColumn;
use App\Filament\Tables\Columns\DeletedAtTextColumn;
use App\Filament\Tables\Columns\EnabledIconColumn;
use App\Filament\Tables\Columns\SortOrderTextColumn;
use App\Filament\Tables\Columns\UpdatedAtTextColumn;
use App\Models\Technology;
use Exception;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
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
                EnabledIconColumn::make(),
                SortOrderTextColumn::make(),
                CreatedAtTextColumn::make(),
                UpdatedAtTextColumn::make(),
                DeletedAtTextColumn::make(),
            ])
            ->actions([
                ViewAction::make()
                    ->modalWidth(MaxWidth::FiveExtraLarge),
                EditAction::make()
                    ->modalWidth(MaxWidth::FiveExtraLarge)
                    ->hidden(
                        fn (Technology $record): bool => $record->trashed()
                    ),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalWidth(MaxWidth::FiveExtraLarge),
            ])
            ->reorderable(
                config('eloquent-sortable.order_column_name'),
                fn (RelationManager $livewire, Table $table): bool => ! is_subclass_of($this->getPageClass(), ViewRecord::class)
            )
            ->defaultSort(config('eloquent-sortable.order_column_name'));
    }
}
