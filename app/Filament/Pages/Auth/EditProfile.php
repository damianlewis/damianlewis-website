<?php

namespace App\Filament\Pages\Auth;

use App\Filament\Resources\UserResource\UserForm;
use Exception;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    /**
     * @throws Exception
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                $this->getAvatarFormComponent(),
            ]);
    }

    /**
     * @throws Exception
     */
    protected function getAvatarFormComponent(): Component
    {
        return UserForm::getAvatarSchema()[0]
            ->hiddenLabel(false);
    }
}
