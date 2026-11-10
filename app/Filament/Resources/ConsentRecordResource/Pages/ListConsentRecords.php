<?php

namespace App\Filament\Resources\ConsentRecordResource\Pages;

use App\Filament\Resources\ConsentRecordResource\ConsentRecordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListConsentRecords extends ListRecords
{
    protected static string $resource = ConsentRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}