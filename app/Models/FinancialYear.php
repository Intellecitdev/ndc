<?php

namespace App\Models;

use App\Models\Concerns\MasterData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialYear extends Model
{
    use MasterData;

    protected $fillable = ['name', 'is_current', 'status'];

    protected $casts = ['is_current' => 'boolean'];

    public static function current(): ?self
    {
        return static::where('is_current', true)->first();
    }
}
