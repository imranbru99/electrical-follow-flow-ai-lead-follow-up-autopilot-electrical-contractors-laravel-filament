<?php

namespace App\Filament\Resources\JobTicketResource\Pages;

use App\Filament\Resources\JobTicketResource\JobTicketResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJobTicket extends EditRecord
{
    protected static string $resource = JobTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}