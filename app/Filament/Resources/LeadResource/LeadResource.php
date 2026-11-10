<?php

namespace App\Filament\Resources\LeadResource;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Sales Autopilot';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('email')->email(),
            TextInput::make('phone')->tel(),
            TextInput::make('company'),
            Select::make('source')->options(['web'=>'Web','phone'=>'Phone','referral'=>'Referral','partner'=>'Partner','jobber'=>'Jobber','servicetitan'=>'ServiceTitan'])->default('web'),
            TextInput::make('service_interest'),
            Select::make('status')->options(['new'=>'New','contacted'=>'Contacted','hot'=>'Hot','won'=>'Won','lost'=>'Lost'])->default('new'),
            Select::make('qualification')->options(['unqualified'=>'Unqualified','qualified'=>'Qualified','nurture'=>'Nurture'])->default('unqualified'),
            Select::make('assigned_to')->relationship('assignee','name')->searchable()->preload(),
            Textarea::make('notes')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('service_interest')->toggleable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('qualification')->badge(),
                TextColumn::make('assignee.name')->label('Owner'),
                TextColumn::make('last_contacted_at')->dateTime()->sortable(),
            ])
            ->filters([])
            ->recordActions([
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
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}