<?php

namespace App\Filament\Resources\UserResource;

use App\Filament\Tables\Columns\CreatedAtTextColumn;
use App\Filament\Tables\Columns\UpdatedAtTextColumn;
use Exception;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserTable
{
    /**
     * @throws Exception
     */
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
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
            ->persistFiltersInSession()
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
