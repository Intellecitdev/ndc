<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    public const PRIORITIES = ['N' => 'Normal', 'M' => 'Medium', 'H' => 'High'];

    protected $fillable = ['sender_id', 'receiver_id', 'priority', 'message', 'read_at'];

    /**
     * Messages exchanged between two users, both directions.
     */
    public function scopeBetween($query, int $a, int $b)
    {
        return $query->where(fn ($q) => $q->where('sender_id', $a)->where('receiver_id', $b))
            ->orWhere(fn ($q) => $q->where('sender_id', $b)->where('receiver_id', $a));
    }

    public function priorityClass(): string
    {
        return ['H' => 'bg-bs-danger text-white', 'M' => 'bg-bs-warning'][$this->priority] ?? '';
    }

    protected function casts(): array
    {
        return ['read_at' => 'datetime'];
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
