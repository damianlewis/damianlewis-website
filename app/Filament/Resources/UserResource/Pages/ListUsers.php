<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\UserResource;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
}
