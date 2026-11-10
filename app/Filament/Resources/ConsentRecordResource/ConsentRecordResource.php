<?php

namespace App\Filament\Resources\ConsentRecordResource;

use App\Filament\Resources\ConsentRecordResource\Pages;
use App\Models\ConsentRecord;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ConsentRecordResource extends Resource
{
    protected static ?string $model = ConsentRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Compliance';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Consent Records';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('lead_id')->relationship('lead', 'name')->required()->searchable()->preload(),
            Select::make('channel')->options([
                'email' => 'Email',
                'sms' => 'SMS',
                'voice' => 'Voice',
            ])->required(),
            Toggle::make('granted')->default(true),
            TextInput::make('source'),
            DateTimePicker::make('granted_at'),
            DateTimePicker::make('revoked_at'),
            Textarea::make('evidence')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lead.name')->searchable(),
                TextColumn::make('channel')->badge(),
                IconColumn::make('granted')->boolean(),
                TextColumn::make('source'),
                TextColumn::make('granted_at')->dateTime(),
                TextColumn::make('revoked_at')->dateTime()->toggleable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConsentRecords::route('/'),
            'create' => Pages\CreateConsentRecord::route('/create'),
            'edit' => Pages\EditConsentRecord::route('/{record}/edit'),
        ];
    }
}
