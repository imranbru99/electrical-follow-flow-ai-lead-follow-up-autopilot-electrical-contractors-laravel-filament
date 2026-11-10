<?php

namespace App\Filament\Resources\FollowUpResource;

use App\Filament\Resources\FollowUpResource\Pages;
use App\Models\FollowUp;
use App\Services\FollowUpAutopilotService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class FollowUpResource extends Resource
{
    protected static ?string $model = FollowUp::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaperAirplane;

    protected static string|UnitEnum|null $navigationGroup = 'Sales Autopilot';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Follow-Ups';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('lead_id')->relationship('lead', 'name')->required()->searchable()->preload(),
            Select::make('channel')->options([
                'email' => 'Email',
                'sms' => 'SMS',
                'voice' => 'Voice',
            ])->required()->default('email'),
            Select::make('status')->options([
                'draft' => 'Draft',
                'pending_approval' => 'Pending Approval',
                'approved' => 'Approved',
                'sent' => 'Sent',
                'blocked' => 'Blocked',
                'failed' => 'Failed',
            ])->default('draft'),
            TextInput::make('subject'),
            Textarea::make('body')->required()->rows(8)->columnSpanFull(),
            Toggle::make('ai_generated')->default(true),
            TextInput::make('ai_classification'),
            TextInput::make('ai_confidence')->numeric(),
            Toggle::make('consent_checked'),
            Toggle::make('consent_ok'),
            Textarea::make('block_reason')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('lead.name')->searchable()->sortable(),
                TextColumn::make('channel')->badge(),
                TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    'sent' => 'success',
                    'approved' => 'info',
                    'pending_approval' => 'warning',
                    'blocked', 'failed' => 'danger',
                    default => 'gray',
                }),
                TextColumn::make('ai_classification')->toggleable(),
                IconColumn::make('consent_ok')->boolean(),
                TextColumn::make('scheduled_at')->dateTime()->toggleable(),
                TextColumn::make('sent_at')->dateTime()->toggleable(),
            ])
            ->filters([])
            ->recordActions([
                Action::make('approve')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->visible(fn (FollowUp $record) => $record->status === 'pending_approval')
                    ->action(function (FollowUp $record) {
                        app(FollowUpAutopilotService::class)->approve($record, auth()->user());
                        Notification::make()->title('Follow-up approved')->success()->send();
                    }),
                Action::make('send')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->visible(fn (FollowUp $record) => $record->status === 'approved')
                    ->requiresConfirmation()
                    ->action(function (FollowUp $record) {
                        app(FollowUpAutopilotService::class)->send($record, auth()->user());
                        Notification::make()->title('Follow-up sent')->success()->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFollowUps::route('/'),
            'create' => Pages\CreateFollowUp::route('/create'),
            'edit' => Pages\EditFollowUp::route('/{record}/edit'),
        ];
    }
}
