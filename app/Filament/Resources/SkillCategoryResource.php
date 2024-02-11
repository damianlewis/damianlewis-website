<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkillCategoryResource\Pages\ListSkillCategories;
use App\Filament\Resources\SkillCategoryResource\SkillCategoryTable;
use App\Models\SkillCategory;
use Exception;
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

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return SkillCategoryTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSkillCategories::route('/'),
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
