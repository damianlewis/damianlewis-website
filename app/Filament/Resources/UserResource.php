<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\CreatedAtPlaceholder;
use App\Filament\Forms\Components\UpdatedAtPlaceholder;
use App\Filament\Infolists\Components\CreatedAtTextEntry;
use App\Filament\Infolists\Components\DateTimeTextEntry;
use App\Filament\Infolists\Components\UpdatedAtTextEntry;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Tables\Columns\CreatedAtTextColumn;
use App\Filament\Tables\Columns\DateTimeTextColumn;
use App\Filament\Tables\Columns\UpdatedAtTextColumn;
use App\Models\Role;
use App\Models\User;
use Exception;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Grid as InfolistGrid;
use Filament\Infolists\Components\Group as InfolistGroup;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistGrid::make([
                    'md' => 3,
                ])
                    ->schema([
                        InfolistGroup::make()
                            ->schema([
                                InfolistSection::make('Details')
                                    ->schema([
                                        TextEntry::make('name')
                                            ->color('gray'),
                                        TextEntry::make('email')
                                            ->color('gray'),
                                    ]),
                            ])
                            ->columnSpan([
                                'md' => 2,
                            ]),
                        InfolistGroup::make()
                            ->schema([
                                InfolistSection::make()
                                    ->schema([
                                        CreatedAtTextEntry::make()
                                            ->color('gray'),
                                        UpdatedAtTextEntry::make()
                                            ->color('gray'),
                                        DateTimeTextEntry::make('email_verified_at')
                                            ->label('Email Verified')
                                            ->color('gray')
                                            ->hidden(fn (User $record): bool => $record->email_verified_at === null),
                                    ]),
                                InfolistSection::make()
                                    ->schema([
                                        TextEntry::make('roles.name')
                                            ->label('Roles')
                                            ->formatStateUsing(fn ($state): string => Str::headline($state))
                                            ->badge(),
                                    ]),
                            ])
                            ->columnSpan([
                                'md' => 1,
                            ]),
                    ]),
            ]);
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'md' => 3,
                ])
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make('Details')
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('email')
                                            ->email()
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255),
                                        TextInput::make('password')
                                            ->password()
                                            ->dehydrated(fn (?string $state): bool => filled($state))
                                            ->required(fn (string $operation): bool => $operation === 'create')
                                            ->confirmed()
                                            ->maxLength(255)
                                            ->live(),
                                        TextInput::make('password_confirmation')
                                            ->password()
                                            ->dehydrated(fn (?string $state): bool => filled($state))
                                            ->required(fn (string $operation): bool => $operation === 'create')
                                            ->maxLength(255)
                                            ->hidden(fn (Get $get): bool => empty($get('password'))),
                                    ]),
                            ])
                            ->columnSpan([
                                'md' => 2,
                            ]),
                        Group::make()
                            ->schema([
                                Section::make()
                                    ->schema([
                                        CreatedAtPlaceholder::make(),
                                        UpdatedAtPlaceholder::make(),
                                        Placeholder::make('email_verified_at')
                                            ->label('Email Verified')
                                            ->content(fn (User $record): string => $record->email_verified_at?->format('d/m/Y H:i'))
                                            ->hidden(fn (User $record): bool => $record->email_verified_at === null),
                                    ])
                                    ->hiddenOn('create'),
                                Section::make('Roles')
                                    ->schema([
                                        Select::make('roles')
                                            ->hiddenLabel()
                                            ->relationship('roles', 'name')
                                            ->getOptionLabelFromRecordUsing(fn (Role $record): string => Str::headline($record->name))
                                            ->multiple()
                                            ->preload()
                                            ->searchable(),
                                    ]),
                            ])
                            ->columnSpan([
                                'md' => 1,
                            ]),
                    ]),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('roles.name')
                    ->formatStateUsing(fn ($state): string => Str::headline($state))
                    ->badge()
                    ->toggleable(),
                DateTimeTextColumn::make('email_verified_at')
                    ->label('Email Verified')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                CreatedAtTextColumn::make(),
                UpdatedAtTextColumn::make(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->relationship('roles', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Role $record): string => Str::headline($record->name))
                    ->multiple()
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
