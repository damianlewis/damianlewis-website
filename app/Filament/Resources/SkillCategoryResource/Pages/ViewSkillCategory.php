<?php

namespace App\Filament\Resources\SkillCategoryResource\Pages;

use App\Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\SkillCategoryResource;
use App\Models\SkillCategory;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;

class ViewSkillCategory extends ViewRecord
{
    protected static string $resource = SkillCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->hidden(
                    fn (SkillCategory $record): bool => $record->trashed()
                ),
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ];
    }
}
