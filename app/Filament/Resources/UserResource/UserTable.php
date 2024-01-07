<?php

namespace App\Filament\Resources\UserResource;

use App\Filament\Tables\Columns\CreatedAtTextColumn;
use App\Filament\Tables\Columns\NameTextColumn;
use App\Filament\Tables\Columns\UpdatedAtTextColumn;
use App\Filament\Tables\ResourceTable;
use Exception;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserTable extends ResourceTable
{
    /**
     * @throws Exception
     */
    public static function make(Table $table): Table
    {
        return parent::make($table)
            ->columns([
                NameTextColumn::make(),
                TextColumn::make('email')
                    ->copyable()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('roles.display_name')
                    ->label('Roles')
                    ->badge()
                    ->toggleable(),
                CreatedAtTextColumn::make(),
                UpdatedAtTextColumn::make(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->relationship('roles', 'display_name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
            ])
            ->persistFiltersInSession();
    }
}
