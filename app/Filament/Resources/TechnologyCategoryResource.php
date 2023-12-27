<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechnologyCategoryResource\Pages\CreateTechnologyCategory;
use App\Filament\Resources\TechnologyCategoryResource\Pages\EditTechnologyCategory;
use App\Filament\Resources\TechnologyCategoryResource\Pages\ListTechnologyCategories;
use App\Filament\Resources\TechnologyCategoryResource\Pages\ViewTechnologyCategory;
use App\Filament\Resources\TechnologyCategoryResource\RelationManagers\TechnologiesRelationManager;
use App\Filament\Resources\TechnologyCategoryResource\TechnologyCategoryForm;
use App\Filament\Resources\TechnologyCategoryResource\TechnologyCategoryInfolist;
use App\Filament\Resources\TechnologyCategoryResource\TechnologyCategoryTable;
use App\Models\TechnologyCategory;
use Exception;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TechnologyCategoryResource extends Resource
{
    protected static ?string $model = TechnologyCategory::class;

    protected static ?string $navigationGroup = 'Technology';

    protected static ?string $navigationLabel = 'Categories';

    protected static ?string $recordTitleAttribute = 'name';

    public static function infolist(Infolist $infolist): Infolist
    {
        return TechnologyCategoryInfolist::make($infolist);

    }

    public static function form(Form $form): Form
    {
        return TechnologyCategoryForm::make($form);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return TechnologyCategoryTable::make($table);
    }

    public static function getRelations(): array
    {
        return [
            TechnologiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTechnologyCategories::route('/'),
            'create' => CreateTechnologyCategory::route('/create'),
            'view' => ViewTechnologyCategory::route('/{record}'),
            'edit' => EditTechnologyCategory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
