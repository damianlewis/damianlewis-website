<?php

namespace App\Filament\Resources\TechnologyCategoryResource\Pages;

use App\Filament\Resources\TechnologyCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTechnologyCategory extends EditRecord
{
    protected static string $resource = TechnologyCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}