<?php

namespace App\Filament\Resources\AttendanceLogResource\Pages;

use App\Filament\Resources\AttendanceLogResource\AttendanceLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAttendanceLogs extends ListRecords
{
    protected static string $resource = AttendanceLogResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}