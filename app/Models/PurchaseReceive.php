<?php

namespace App\Models;

use App\Models\Concerns\MasterData;
use App\Models\Concerns\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseReceive extends Model
{
    use MasterData, RequiresApproval;

    protected $fillable = ['invoice_no', 'date', 'unit_id', 'supplier_id', 'purchase_order_id', 'financial_year_id', 'received_qty', 'status'];

    protected $casts = ['date' => 'date'];

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseReceiveItem::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function financialYear(): BelongsTo
    {
        return $this->belongsTo(FinancialYear::class);
    }

    public function approvalCard(): array
    {
        return ['stock', 'New Stock Entry', $this->invoice_no, "Stock entry {$this->invoice_no} against {$this->purchaseOrder?->po_no} is pending QM approval.",
            array_values(array_filter([$this->invoice_no, "{$this->received_qty} pcs", $this->supplier?->name])), $this->unit_id, route('inventory.purchase.purchaseorderreceive.show', $this->id)];
    }

    /** The received stock goes live. */
    public function onApproved(): void
    {
        $this->stocks()->where('status', Stock::PENDING)->update(['status' => Stock::IN_STOCK]);
    }

    /** Nothing reaches the stock: drop the pending rows and give the quantity back to the PO. */
    public function onRejected(): void
    {
        foreach ($this->items()->with('orderItem')->get() as $line) {
            $line->orderItem?->decrement('received_qty', $line->quantity);
        }
        $this->stocks()->delete();
    }
}
