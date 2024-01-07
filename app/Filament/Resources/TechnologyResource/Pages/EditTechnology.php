<?php

namespace App\Filament\Resources\TechnologyResource\Pages;

use App\Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\TechnologyResource;
use App\Models\Technology;

class EditTechnology extends EditRecord
{
    protected static string $resource = TechnologyResource::class;

    protected function beforeSave(): void
    {
        /** @var Technology $record */
        $record = $this->getRecord();

        if ($record->isDirty('technology_category_id') && $record->hasChildren()) {
            $record->children()->update([
                'parent_id' => null,
            ]);
        }
    }
}
