<?php

namespace App\Filament\Resources\TechnologyCategoryResource\Pages;

use App\Filament\Resources\TechnologyCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTechnologyCategory extends CreateRecord
{
    protected static string $resource = TechnologyCategoryResource::class;

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
