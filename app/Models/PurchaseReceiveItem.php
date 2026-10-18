<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseReceiveItem extends Model
{
    protected $fillable = ['purchase_receive_id', 'purchase_order_item_id', 'item_id', 'quantity'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrderItem::class, 'purchase_order_item_id');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }
}
