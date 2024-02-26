<?php

namespace App\Filament\Resources\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord as BaseViewRecord;

class ViewRecord extends BaseViewRecord
{
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
