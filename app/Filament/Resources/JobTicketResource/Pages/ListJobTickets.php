<?php

namespace App\Filament\Resources\JobTicketResource\Pages;

use App\Filament\Resources\JobTicketResource\JobTicketResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJobTickets extends ListRecords
{
    protected static string $resource = JobTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}