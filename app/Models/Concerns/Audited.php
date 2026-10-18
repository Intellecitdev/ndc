<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Fills created_by / updated_by and writes the activity log.
 */
trait Audited
{
    use LogsActivity;

    protected static function bootAudited(): void
    {
        static::creating(function ($model) {
            $model->created_by ??= auth()->id();
            $model->updated_by ??= auth()->id();
        });
        static::updating(fn ($model) => $model->updated_by = auth()->id() ?? $model->updated_by);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
