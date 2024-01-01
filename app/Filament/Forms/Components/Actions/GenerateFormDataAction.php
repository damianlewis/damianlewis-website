<?php

namespace App\Filament\Forms\Components\Actions;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;

class GenerateFormDataAction extends Action
{
    public static function makeFor(
        Form $form,
        array $data,
        ?string $name = 'generate_form_data'
    ): static {
        return parent::make($name)
            ->action(fn () => $form->fill($data))
            ->visible(function (string $operation): bool {
                if ($operation !== 'create') {
                    return false;
                }

                if (! app()->environment('local')) {
                    return false;
                }

                return true;
            });
    }
}
