<?php

use App\Models\ActivityLog;

if (! function_exists('activity_log')) {
    function activity_log(
        string $action,
        ?string $module = null,
        $subject = null,
        ?string $description = null,
        array $properties = []
    ): void {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => $module,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->id,
            'description' => $description,
            'properties' => $properties ?: null,
        ]);
    }
}
