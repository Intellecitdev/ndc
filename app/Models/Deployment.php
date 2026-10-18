<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Deployment extends Model
{
    use Audited;

    protected $fillable = ['stock_id', 'unit_id', 'quantity', 'deploy_date', 'personnel', 'comments'];

    protected $casts = ['deploy_date' => 'date'];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function license(): HasOne
    {
        return $this->hasOne(License::class);
    }
}
