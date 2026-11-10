<?php

namespace App\Services;

use App\Models\FollowUp;

/** Local equivalent of imrandevbd/laravel-unicode-pdf */
class UnicodePdfService
{
    public function renderFollowUpReport(FollowUp $followUp): string
    {
        $lead = $followUp->lead;
        $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Follow-Up #{$followUp->id}</title></head>
<body>
<h1>ElectricalFollowFlow — Follow-Up Report</h1>
<p><strong>Lead:</strong> {$lead->name}</p>
<p><strong>Channel:</strong> {$followUp->channel}</p>
<p><strong>Status:</strong> {$followUp->status}</p>
<p><strong>Classification:</strong> {$followUp->ai_classification}</p>
<hr>
<pre>{$followUp->body}</pre>
</body>
</html>
HTML;

        $path = storage_path('app/public/follow-up-'.$followUp->id.'.html');
        file_put_contents($path, $html);

        return $path;
    }
}
