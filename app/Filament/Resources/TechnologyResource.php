<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechnologyResource\Pages\CreateTechnology;
use App\Filament\Resources\TechnologyResource\Pages\EditTechnology;
use App\Filament\Resources\TechnologyResource\Pages\ListTechnologies;
use App\Filament\Resources\TechnologyResource\Pages\ViewTechnology;
use App\Filament\Resources\TechnologyResource\TechnologyForm;
use App\Filament\Resources\TechnologyResource\TechnologyInfolist;
use App\Filament\Resources\TechnologyResource\TechnologyTable;
use App\Models\Technology;
use Exception;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TechnologyResource extends Resource
{
    protected static ?string $model = Technology::class;

    protected static ?string $navigationGroup = 'Technology';

    public static function infolist(Infolist $infolist): Infolist
    {
        return TechnologyInfolist::make($infolist);
    }

    public static function form(Form $form): Form
    {
        return TechnologyForm::make($form);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return TechnologyTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTechnologies::route('/'),
            'create' => CreateTechnology::route('/create'),
            'view' => ViewTechnology::route('/{record}'),
            'edit' => EditTechnology::route('/{record}/edit'),
        ];
    }

    //    public static function getEloquentQuery(): Builder
    //    {
    //        return parent::getEloquentQuery()
    //            ->withoutGlobalScopes([
    //                SoftDeletingScope::class,
    //            ]);
    //    }
}
