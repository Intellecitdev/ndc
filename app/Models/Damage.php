<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Damage extends Model
{
    use Audited;

    protected $fillable = ['stock_id', 'unit_id', 'quantity', 'date', 'reason', 'actions', 'remarks', 'status', 'approved_by', 'approved_at'];

    protected $casts = ['date' => 'date', 'approved_at' => 'datetime'];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function claim(): HasOne
    {
        return $this->hasOne(WarrantyClaim::class);
    }
}
