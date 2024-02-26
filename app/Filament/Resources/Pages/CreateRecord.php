<?php

namespace App\Filament\Resources\Pages;

use Filament\Resources\Pages\CreateRecord as BaseCreateRecord;

class CreateRecord extends BaseCreateRecord
{
    protected function getRedirectUrl(): string
    {
        return self::getResource()::getUrl(
            'edit',
            [
                'record' => $this->getRecord(),
            ]
        );
    }
}
