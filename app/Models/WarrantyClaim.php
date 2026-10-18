<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarrantyClaim extends Model
{
    use Audited;

    /** Receive outcomes offered in the reference. */
    public const RECEIVE_STATUSES = [
        'Received' => 'Item received in good condition',
        'Not Covered' => 'Item does not cover warranty terms',
    ];

    protected $fillable = ['damage_id', 'stock_id', 'unit_id', 'type', 'status', 'claim_date', 'comments', 'expected_return_date', 'claimed_by', 'received_by', 'received_at'];

    protected $casts = ['claim_date' => 'date', 'expected_return_date' => 'date', 'received_at' => 'datetime'];

    public function damage(): BelongsTo
    {
        return $this->belongsTo(Damage::class);
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function claimer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'claimed_by');
    }
}
