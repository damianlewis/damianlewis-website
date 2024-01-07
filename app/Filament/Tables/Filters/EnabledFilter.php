<?php

namespace App\Filament\Tables\Filters;

use Exception;
use Filament\Tables\Filters\TernaryFilter;

class EnabledFilter extends TernaryFilter
{
    /**
     * @throws Exception
     */
    public static function make(?string $name = 'enabled'): static
    {
        return parent::make($name)
            ->native(false)
            ->placeholder('All');
    }
}
