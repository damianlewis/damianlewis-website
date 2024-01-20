<?php

namespace App\Filament\Resources\TechnologyResource\Pages;

use App\Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\TechnologyResource;
use App\Models\Technology;
use App\Models\TechnologyCategory;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Forms\Components\Select;

class ViewTechnology extends ViewRecord
{
    protected static string $resource = TechnologyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->hidden(
                    fn (Technology $record): bool => $record->trashed()
                ),
            RestoreAction::make()
                ->form(function (Technology $record): ?array {
                    if ($record->doesntHaveCategory()) {
                        return [
                            Select::make('technology_category_id')
                                ->label('Category')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->exists(
                                    TechnologyCategory::class,
                                    (new TechnologyCategory)->getKeyName()
                                ),
                        ];
                    }

                    return null;
                }),
            ForceDeleteAction::make(),
        ];
    }
}
