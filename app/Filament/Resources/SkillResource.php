<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkillResource\Pages\ListSkills;
use App\Filament\Resources\SkillResource\SkillTable;
use App\Models\Skill;
use Exception;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static ?string $navigationGroup = 'Skill';

    protected static ?int $navigationSort = 2;

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return SkillTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSkills::route('/'),
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
