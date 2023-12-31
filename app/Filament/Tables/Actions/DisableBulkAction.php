<?php

namespace App\Filament\Tables\Actions;

use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class DisableBulkAction extends BulkAction
{
    public static function make(
        ?string $name = 'disabled'
    ): static {
        return parent::make($name)
            ->label('Disable selected')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->action(function (Collection $records, BulkAction $action) {
                $records->each->disable();

                $action->successNotificationTitle('Disabled');
                $action->sendSuccessNotification();
            });
    }
}
