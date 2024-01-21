<?php

namespace App\Filament\Resources\UserResource;

use App\Filament\Tables\Columns\CreatedAtTextColumn;
use App\Filament\Tables\Columns\DeletedAtTextColumn;
use App\Filament\Tables\Columns\NameTextColumn;
use App\Filament\Tables\Columns\UpdatedAtTextColumn;
use App\Filament\Tables\ResourceTable;
use App\Models\User;
use Exception;
use Filament\Support\Enums\FontFamily;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                    ->fontFamily(FontFamily::Mono)
                    ->copyable()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('roles.display_name')
                    ->label('Roles')
                    ->badge()
                    ->toggleable(),
                IconColumn::make('blocked_at')
                    ->label('Blocked')
                    ->state(fn (User $record): bool => $record->isBlocked())
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                CreatedAtTextColumn::make(),
                UpdatedAtTextColumn::make(),
                DeletedAtTextColumn::make(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->relationship('roles', 'display_name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('blocked_at')
                    ->label('Blocked')
                    ->native(false)
                    ->queries(
                        fn (Builder $query): Builder => $query->whereNotNull('blocked_at'),
                        fn (Builder $query): Builder => $query->whereNull('blocked_at'),
                    ),
                TrashedFilter::make()
                    ->native(false),
            ])
            ->persistFiltersInSession();
    }
}
