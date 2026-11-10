<?php

namespace App\Filament\Resources\TechnicianResource;

use App\Filament\Resources\TechnicianResource\Pages;
use App\Models\Technician;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class TechnicianResource extends Resource
{
    protected static ?string $model = Technician::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|UnitEnum|null $navigationGroup = 'Field Operations';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')->relationship('user', 'name')->searchable()->preload(),
            TextInput::make('name')->required(),
            TextInput::make('email')->email(),
            TextInput::make('phone'),
            TextInput::make('license_number'),
            TextInput::make('specialty'),
            TextInput::make('zone'),
            Select::make('status')->options([
                'available' => 'Available',
                'on_job' => 'On Job',
                'off_duty' => 'Off Duty',
            ])->default('available'),
            Toggle::make('licensed')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('license_number'),
                TextColumn::make('specialty'),
                TextColumn::make('zone'),
                TextColumn::make('status')->badge(),
                IconColumn::make('licensed')->boolean(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTechnicians::route('/'),
            'create' => Pages\CreateTechnician::route('/create'),
            'edit' => Pages\EditTechnician::route('/{record}/edit'),
        ];
    }
}
