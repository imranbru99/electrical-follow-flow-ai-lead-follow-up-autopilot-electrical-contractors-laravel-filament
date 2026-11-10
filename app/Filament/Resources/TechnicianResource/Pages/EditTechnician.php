<?php

namespace App\Filament\Resources\TechnicianResource\Pages;

use App\Filament\Resources\TechnicianResource\TechnicianResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTechnician extends EditRecord
{
    protected static string $resource = TechnicianResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}