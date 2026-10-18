<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuickLink extends Model
{
    protected $fillable = ['user_id', 'title', 'link', 'is_active'];

    /** Bookmarks are http(s) URLs or app paths — never javascript:, data: or protocol-relative links. */
    public const LINK_PATTERN = '#^(https?://|/(?!/))#i';

    public static function isSafeLink(?string $link): bool
    {
        return (bool) preg_match(self::LINK_PATTERN, (string) $link);
    }

    /** The link for href attributes; anything unsafe (e.g. stored before validation existed) becomes "#". */
    public function safeLink(): string
    {
        return self::isSafeLink($this->link) ? $this->link : '#';
    }

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
