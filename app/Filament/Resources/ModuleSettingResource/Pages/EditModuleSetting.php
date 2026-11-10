<?php

namespace App\Filament\Resources\ModuleSettingResource\Pages;

use App\Filament\Resources\ModuleSettingResource\ModuleSettingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditModuleSetting extends EditRecord
{
    protected static string $resource = ModuleSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}