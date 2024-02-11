<?php

namespace App\Filament\Resources\SkillResource\Pages;

use App\Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\SkillResource;
use App\Models\Skill;
use App\Models\SkillCategory;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Forms\Components\Select;

class ViewSkill extends ViewRecord
{
    protected static string $resource = SkillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->hidden(
                    fn (Skill $record): bool => $record->trashed()
                ),
            RestoreAction::make()
                ->form(function (Skill $record): ?array {
                    if ($record->doesntHaveCategory()) {
                        return [
                            Select::make($record->category()->getForeignKeyName())
                                ->label('Category')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->exists(
                                    SkillCategory::class,
                                    (new SkillCategory)->getKeyName()
                                ),
                        ];
                    }

                    return null;
                }),
            ForceDeleteAction::make(),
        ];
    }
}
