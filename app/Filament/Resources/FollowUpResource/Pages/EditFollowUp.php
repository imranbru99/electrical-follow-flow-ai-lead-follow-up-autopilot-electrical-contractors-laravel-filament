<?php

namespace App\Filament\Resources\FollowUpResource\Pages;

use App\Filament\Resources\FollowUpResource\FollowUpResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFollowUp extends EditRecord
{
    protected static string $resource = FollowUpResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}