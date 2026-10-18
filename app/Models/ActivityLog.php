<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = ['subject', 'url', 'method', 'ip', 'agent', 'user_id', 'old_data', 'new_data'];

    protected function casts(): array
    {
        return ['old_data' => 'array', 'new_data' => 'array'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $subject, ?array $old = null, ?array $new = null, ?int $userId = null): void
    {
        $request = request();
        static::create([
            'subject' => substr($subject, 0, 250),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'agent' => substr((string) $request->userAgent(), 0, 500),
            'user_id' => $userId ?? auth()->id(),
            'old_data' => $old,
            'new_data' => $new,
        ]);
    }
}
