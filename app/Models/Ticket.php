<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use LogsActivity;

    protected $fillable = ['user_id', 'subject', 'details', 'attachment', 'read_at', 'status', 'close_note', 'closed_by', 'closed_at'];

    protected function casts(): array
    {
        return ['read_at' => 'datetime', 'closed_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class)->oldest();
    }
}
