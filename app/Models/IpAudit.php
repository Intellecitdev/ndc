<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpAudit extends Model
{
    public const REASONS = ['Blacklisted', 'Not Whitelisted', 'Failed Login', 'Too Many Login Attempts'];

    protected $fillable = ['ip', 'url', 'user_agent', 'blocked', 'reason'];

    protected function casts(): array
    {
        return ['blocked' => 'boolean'];
    }

    public static function record(string $reason, bool $blocked = true): void
    {
        $request = request();
        static::create([
            'ip' => $request->ip(),
            'url' => $request->fullUrl(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
            'blocked' => $blocked,
            'reason' => $reason,
        ]);
    }
}
