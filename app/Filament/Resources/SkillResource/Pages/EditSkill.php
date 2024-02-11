<?php

namespace App\Filament\Resources\SkillResource\Pages;

use App\Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SkillResource;
use App\Models\Skill;

class EditSkill extends EditRecord
{
    protected static string $resource = SkillResource::class;

    protected function beforeSave(): void
    {
        /** @var Skill $record */
        $record = $this->getRecord();

        $categoryForeignKeyName = $record->category()->getForeignKeyName();

        if ($record->isDirty($categoryForeignKeyName) && $record->hasChildrenWithTrashed()) {
            $record->children()->withTrashed()->each(
                function (Skill $child) use ($record, $categoryForeignKeyName): void {
                    $child->{$categoryForeignKeyName} = $record->{$categoryForeignKeyName};
                    $child->save();
                }
            );
        }
    }
}
