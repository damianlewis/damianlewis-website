<?php

namespace App\Filament\Forms;

use Filament\Forms\Form;

class ResourceForm
{
    private static bool $showHelp = false;

    public static function make(Form $form): Form
    {
        self::setShowHelp((bool) session('filament.console.showHelp'));

        return $form;
    }

    public static function showHelp(): bool
    {
        return self::$showHelp;
    }

    public static function setShowHelp(bool $showHelp): void
    {
        self::$showHelp = $showHelp;
    }

    public static function help(?string $help = null): ?string
    {
        return self::showHelp() ? $help : null;
    }
}
