<?php

namespace App\Filament\Widgets;

use App\Models\Escalation;
use App\Models\FollowUp;
use App\Models\JobTicket;
use App\Models\Lead;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OpsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Open Leads', Lead::query()->whereIn('status', ['new', 'contacted', 'hot'])->count())
                ->description('Active pipeline')
                ->color('warning'),
            Stat::make('Pending Approvals', FollowUp::query()->where('status', 'pending_approval')->count())
                ->description('AI drafts awaiting human review')
                ->color('info'),
            Stat::make('Open Escalations', Escalation::query()->where('status', 'open')->count())
                ->description('Qualified replies needing staff')
                ->color('danger'),
            Stat::make('Active Job Tickets', JobTicket::query()->whereIn('status', ['scheduled', 'en_route', 'on_site'])->count())
                ->description('Field work in motion')
                ->color('success'),
        ];
    }
}
