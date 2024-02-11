<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkillResource\Pages\CreateSkill;
use App\Filament\Resources\SkillResource\Pages\ListSkills;
use App\Filament\Resources\SkillResource\SkillForm;
use App\Filament\Resources\SkillResource\SkillTable;
use App\Models\Skill;
use Exception;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static ?string $navigationGroup = 'Skill';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return SkillForm::make($form);
    }

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
            'create' => CreateSkill::route('/create'),
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
