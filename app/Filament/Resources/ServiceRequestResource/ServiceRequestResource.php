<?php

namespace App\Filament\Resources\ServiceRequestResource;

use App\Filament\Resources\ServiceRequestResource\Pages;
use App\Models\ServiceRequest;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ServiceRequestResource extends Resource
{
    protected static ?string $model = ServiceRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|UnitEnum|null $navigationGroup = 'Field Operations';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('lead_id')->relationship('lead', 'name')->searchable()->preload(),
            TextInput::make('reference')->required()->unique(ignoreRecord: true),
            TextInput::make('title')->required(),
            Textarea::make('description')->columnSpanFull(),
            Select::make('priority')->options([
                'low' => 'Low',
                'normal' => 'Normal',
                'high' => 'High',
                'emergency' => 'Emergency',
            ])->default('normal'),
            Select::make('status')->options([
                'open' => 'Open',
                'scheduled' => 'Scheduled',
                'in_progress' => 'In Progress',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ])->default('open'),
            TextInput::make('service_type'),
            TextInput::make('address'),
            TextInput::make('city'),
            TextInput::make('state'),
            TextInput::make('zip'),
            DateTimePicker::make('requested_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')->searchable()->sortable(),
                TextColumn::make('title')->searchable(),
                TextColumn::make('lead.name')->label('Lead'),
                TextColumn::make('priority')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('city')->toggleable(),
                TextColumn::make('requested_at')->dateTime()->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceRequests::route('/'),
            'create' => Pages\CreateServiceRequest::route('/create'),
            'edit' => Pages\EditServiceRequest::route('/{record}/edit'),
        ];
    }
}
