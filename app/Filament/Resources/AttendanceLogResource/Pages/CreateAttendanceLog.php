<?php

namespace App\Filament\Resources\AttendanceLogResource\Pages;

use App\Filament\Resources\AttendanceLogResource\AttendanceLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendanceLog extends CreateRecord
{
    protected static string $resource = AttendanceLogResource::class;
}