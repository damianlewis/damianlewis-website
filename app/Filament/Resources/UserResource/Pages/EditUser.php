<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('block')
                ->requiresConfirmation()
                ->modalHeading('Block User')
                ->before(function (Action $action, User $record): void {
                    $title = match (true) {
                        $record->isBlocked() => 'User already blocked',
                        $record->getKey() === auth()->id() => 'You cannot block yourself',
                        default => null,
                    };

                    if ($title !== null) {
                        $action->failureNotificationTitle($title);
                        $action->failure();
                        $action->halt();
                    }
                })
                ->action(function (Action $action, User $record): void {
                    $record->block();

                    $action->successNotificationTitle('User blocked');
                    $action->success();
                })
                ->hidden(
                    fn (User $record): bool => $record->isBlocked() || $record->getKey() === auth()->id()
                ),
            Action::make('unblock')
                ->requiresConfirmation()
                ->modalHeading('Unblock User')
                ->before(function (Action $action, User $record): void {
                    if ($record->isNotBlocked()) {
                        $action->failureNotificationTitle('User is already unblocked');
                        $action->failure();
                        $action->halt();
                    }
                })
                ->action(function (Action $action, User $record): void {
                    $record->unblock();

                    $action->successNotificationTitle('User unblocked');
                    $action->success();
                })
                ->hidden(fn (User $record): bool => $record->isNotBlocked()),
            DeleteAction::make(),
        ];
    }
}
