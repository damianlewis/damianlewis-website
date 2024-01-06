<?php

namespace App\Filament\Resources\TechnologyCategoryResource\Pages;

use App\Filament\Resources\TechnologyCategoryResource;
use App\Models\TechnologyCategory;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTechnologyCategory extends ViewRecord
{
    protected static string $resource = TechnologyCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->hidden(
                    fn (TechnologyCategory $record): bool => $record->trashed()
                ),
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ];
    }
}
