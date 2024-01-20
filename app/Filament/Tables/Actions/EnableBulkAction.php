<?php

namespace App\Filament\Tables\Actions;

use App\Contracts\EnableInterface;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class EnableBulkAction extends BulkAction
{
    public static function make(?string $name = 'enabled'): static
    {
        return parent::make($name)
            ->label('Enable selected')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->action(function (Collection $records, BulkAction $action) {
                $records->each(fn (EnableInterface $record) => $record->enable());

                $action->successNotificationTitle('Enabled');
                $action->sendSuccessNotification();
            });
    }
}
