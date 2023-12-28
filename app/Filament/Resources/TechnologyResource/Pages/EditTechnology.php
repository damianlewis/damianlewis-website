<?php

namespace App\Filament\Resources\TechnologyResource\Pages;

use App\Filament\Resources\TechnologyResource;
use App\Models\Technology;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTechnology extends EditRecord
{
    protected static string $resource = TechnologyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->after(function (Technology $record) {
                    if ($record->hasChildren()) {
                        $record->children->each(fn (Technology $child) => $child->update(['parent_id' => null]));
                    }
                }),
        ];
    }
}
