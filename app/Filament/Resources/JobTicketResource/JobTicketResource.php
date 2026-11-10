<?php

namespace App\Filament\Resources\JobTicketResource;

use App\Filament\Resources\JobTicketResource\Pages;
use App\Models\JobTicket;
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

class JobTicketResource extends Resource
{
    protected static ?string $model = JobTicket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'Field Operations';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('ticket_number')->required()->unique(ignoreRecord: true),
            Select::make('service_request_id')->relationship('serviceRequest', 'reference')->searchable()->preload(),
            Select::make('technician_id')->relationship('technician', 'name')->searchable()->preload(),
            Select::make('lead_id')->relationship('lead', 'name')->searchable()->preload(),
            TextInput::make('title')->required(),
            Textarea::make('notes')->columnSpanFull(),
            Select::make('status')->options([
                'scheduled' => 'Scheduled',
                'en_route' => 'En Route',
                'on_site' => 'On Site',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ])->default('scheduled'),
            DateTimePicker::make('scheduled_for'),
            DateTimePicker::make('completed_at'),
            TextInput::make('estimated_hours')->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')->searchable()->sortable(),
                TextColumn::make('title')->searchable(),
                TextColumn::make('technician.name')->label('Tech'),
                TextColumn::make('status')->badge(),
                TextColumn::make('scheduled_for')->dateTime()->sortable(),
                TextColumn::make('estimated_hours')->toggleable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobTickets::route('/'),
            'create' => Pages\CreateJobTicket::route('/create'),
            'edit' => Pages\EditJobTicket::route('/{record}/edit'),
        ];
    }
}
