<?php

namespace App\Filament\Resources\ModuleSettingResource;

use App\Filament\Resources\ModuleSettingResource\Pages;
use App\Models\ModuleSetting;
use BackedEnum;
use Filament\Actions\EditAction;
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

class ModuleSettingResource extends Resource
{
    protected static ?string $model = ModuleSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Platform';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Feature Modules';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('key')->disabled()->dehydrated(),
            TextInput::make('label')->required(),
            Textarea::make('description')->columnSpanFull(),
            Toggle::make('enabled'),
            Toggle::make('core')->disabled()->dehydrated(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')->searchable()->sortable(),
                TextColumn::make('key')->badge(),
                IconColumn::make('enabled')->boolean(),
                IconColumn::make('core')->boolean(),
                TextColumn::make('description')->limit(50)->toggleable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListModuleSettings::route('/'),
            'edit' => Pages\EditModuleSetting::route('/{record}/edit'),
        ];
    }
}
