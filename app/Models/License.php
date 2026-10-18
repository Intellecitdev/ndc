<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class License extends Model
{
    use Audited;

    protected $fillable = ['deployment_id', 'stock_id', 'product_key', 'manufacturer', 'licensed_to_name', 'licensed_to_email', 're_assignable', 'purchase_date', 'expiration_date', 'note'];

    protected $casts = ['purchase_date' => 'date', 'expiration_date' => 'date', 're_assignable' => 'boolean'];

    public function deployment(): BelongsTo
    {
        return $this->belongsTo(Deployment::class);
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}
