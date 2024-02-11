<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkillCategoryResource\Pages\CreateSkillCategory;
use App\Filament\Resources\SkillCategoryResource\Pages\EditSkillCategory;
use App\Filament\Resources\SkillCategoryResource\Pages\ListSkillCategories;
use App\Filament\Resources\SkillCategoryResource\Pages\ViewSkillCategory;
use App\Filament\Resources\SkillCategoryResource\RelationManagers\SkillsRelationManager;
use App\Filament\Resources\SkillCategoryResource\SkillCategoryForm;
use App\Filament\Resources\SkillCategoryResource\SkillCategoryInfolist;
use App\Filament\Resources\SkillCategoryResource\SkillCategoryTable;
use App\Models\SkillCategory;
use Exception;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SkillCategoryResource extends Resource
{
    protected static ?string $model = SkillCategory::class;

    protected static ?string $navigationGroup = 'Skill';

    protected static ?string $navigationLabel = 'Categories';

    protected static ?int $navigationSort = 1;

    public static function infolist(Infolist $infolist): Infolist
    {
        return SkillCategoryInfolist::make($infolist);

    }

    public static function form(Form $form): Form
    {
        return SkillCategoryForm::make($form);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return SkillCategoryTable::make($table);
    }

    public static function getRelations(): array
    {
        return [
            SkillsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSkillCategories::route('/'),
            'create' => CreateSkillCategory::route('/create'),
            'view' => ViewSkillCategory::route('/{record}'),
            'edit' => EditSkillCategory::route('/{record}/edit'),
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
