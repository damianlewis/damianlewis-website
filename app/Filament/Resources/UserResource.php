<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\UserForm;
use App\Filament\Resources\UserResource\UserInfolist;
use App\Filament\Resources\UserResource\UserTable;
use App\Models\User;
use Exception;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function infolist(Infolist $infolist): Infolist
    {
        return UserInfolist::make($infolist);
    }

    public static function form(Form $form): Form
    {
        return UserForm::make($form);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return UserTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
