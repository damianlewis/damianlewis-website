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

        $categoryForeignKeyName = $record->category()->getForeignKeyName();

        if ($record->isDirty($categoryForeignKeyName) && $record->hasChildrenWithTrashed()) {
            $record->children()->withTrashed()->each(
                function (Technology $child) use ($record, $categoryForeignKeyName): void {
                    $child->{$categoryForeignKeyName} = $record->{$categoryForeignKeyName};
                    $child->save();
                }
            );
        }
    }
}
