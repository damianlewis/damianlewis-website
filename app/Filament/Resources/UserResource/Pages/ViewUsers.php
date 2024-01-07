<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\UserResource;
use Filament\Actions\EditAction;

class ViewUsers extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
