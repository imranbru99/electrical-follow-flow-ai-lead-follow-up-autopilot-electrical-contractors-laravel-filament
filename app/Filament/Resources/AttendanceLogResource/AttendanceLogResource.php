<?php

namespace App\Filament\Resources\AttendanceLogResource;

use App\Filament\Resources\AttendanceLogResource\Pages;
use App\Models\AttendanceLog;
use App\Models\ModuleSetting;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class AttendanceLogResource extends Resource
{
    protected static ?string $model = AttendanceLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static string|UnitEnum|null $navigationGroup = 'Field Operations';

    protected static ?int $navigationSort = 4;

    public static function shouldRegisterNavigation(): bool
    {
        return ModuleSetting::isEnabled('attendance_hub');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('technician_id')->relationship('technician', 'name')->required()->searchable()->preload(),
            Select::make('event')->options([
                'clock_in' => 'Clock In',
                'clock_out' => 'Clock Out',
            ])->required(),
            TextInput::make('device'),
            TextInput::make('location'),
            DateTimePicker::make('occurred_at')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('technician.name')->searchable(),
                TextColumn::make('event')->badge(),
                TextColumn::make('device'),
                TextColumn::make('location'),
                TextColumn::make('occurred_at')->dateTime()->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendanceLogs::route('/'),
            'create' => Pages\CreateAttendanceLog::route('/create'),
            'edit' => Pages\EditAttendanceLog::route('/{record}/edit'),
        ];
    }
}
