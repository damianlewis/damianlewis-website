<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;

class ViewUsers extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->hidden(
                    fn (User $record): bool => $record->trashed()
                ),
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ];
    }
}
