<?php

namespace App\Filament\Resources\ConsentRecordResource\Pages;

use App\Filament\Resources\ConsentRecordResource\ConsentRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditConsentRecord extends EditRecord
{
    protected static string $resource = ConsentRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}