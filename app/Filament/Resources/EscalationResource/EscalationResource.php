<?php

namespace App\Filament\Resources\EscalationResource;

use App\Filament\Resources\EscalationResource\Pages;
use App\Models\Escalation;
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

class EscalationResource extends Resource
{
    protected static ?string $model = Escalation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    protected static string|UnitEnum|null $navigationGroup = 'Sales Autopilot';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('lead_id')->relationship('lead', 'name')->required()->searchable()->preload(),
            Select::make('follow_up_id')->relationship('followUp', 'id')->searchable()->preload(),
            Select::make('assigned_to')->relationship('assignee', 'name')->searchable()->preload(),
            TextInput::make('reason')->required(),
            Select::make('priority')->options([
                'low' => 'Low',
                'medium' => 'Medium',
                'high' => 'High',
                'critical' => 'Critical',
            ])->default('high'),
            Select::make('status')->options([
                'open' => 'Open',
                'in_progress' => 'In Progress',
                'resolved' => 'Resolved',
            ])->default('open'),
            Textarea::make('reply_excerpt')->columnSpanFull(),
            DateTimePicker::make('resolved_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lead.name')->searchable(),
                TextColumn::make('reason')->limit(40),
                TextColumn::make('priority')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('assignee.name')->label('Assigned'),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEscalations::route('/'),
            'create' => Pages\CreateEscalation::route('/create'),
            'edit' => Pages\EditEscalation::route('/{record}/edit'),
        ];
    }
}
