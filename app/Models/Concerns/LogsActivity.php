<?php

namespace App\Models\Concerns;

use App\Models\ActivityLog;
use Illuminate\Support\Str;

/**
 * Writes create/update/delete of the model to Admin > Log Activity,
 * with old and new values for the "Compare Data" view.
 */
trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        $label = fn ($model) => Str::headline(class_basename($model));
        // Housekeeping columns are not worth a log entry on their own.
        $hidden = fn (array $data, $model) => collect($data)
            ->except(array_merge($model->getHidden(), ['updated_at', 'created_at', 'last_login_at', 'remember_token']))
            ->all();

        static::created(fn ($model) => ActivityLog::record($label($model).' Created', null, $hidden($model->getAttributes(), $model)));

        static::updated(function ($model) use ($label, $hidden) {
            $changes = $hidden($model->getChanges(), $model);
            if ($changes) {
                ActivityLog::record($label($model).' Updated', $hidden(array_intersect_key($model->getOriginal(), $changes), $model), $changes);
            }
        });

        static::deleted(fn ($model) => ActivityLog::record($label($model).' Deleted', $hidden($model->getOriginal(), $model)));
    }
}
