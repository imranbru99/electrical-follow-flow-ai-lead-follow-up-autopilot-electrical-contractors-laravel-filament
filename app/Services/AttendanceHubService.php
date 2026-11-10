<?php

namespace App\Services;

use App\Models\AttendanceLog;
use App\Models\Technician;

/** Local equivalent of imrandevbd/laravel-attendance-hub */
class AttendanceHubService
{
    public function clockIn(Technician $technician, ?string $device = null, ?string $location = null): AttendanceLog
    {
        $log = AttendanceLog::query()->create([
            'technician_id' => $technician->id,
            'event' => 'clock_in',
            'device' => $device ?? 'manual',
            'occurred_at' => now(),
            'location' => $location,
        ]);

        $technician->update(['status' => 'on_job']);

        return $log;
    }

    public function clockOut(Technician $technician, ?string $device = null, ?string $location = null): AttendanceLog
    {
        $log = AttendanceLog::query()->create([
            'technician_id' => $technician->id,
            'event' => 'clock_out',
            'device' => $device ?? 'manual',
            'occurred_at' => now(),
            'location' => $location,
        ]);

        $technician->update(['status' => 'available']);

        return $log;
    }
}
