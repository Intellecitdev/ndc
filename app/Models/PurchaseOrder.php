<?php

namespace App\Models;

use App\Models\Concerns\MasterData;
use App\Models\Concerns\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    use MasterData, RequiresApproval;

    public const PRIORITIES = [1 => 'Highest', 2 => 'Medium', 3 => 'Normal'];

    protected $fillable = ['po_no', 'date', 'unit_id', 'supplier_id', 'financial_year_id', 'reference_no', 'priority', 'attachment', 'comments', 'status'];

    protected $casts = ['date' => 'date'];

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function receives(): HasMany
    {
        return $this->hasMany(PurchaseReceive::class);
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

    /** PO000002/2026-2027 */
    public static function makeNumber(int $id, string $finYear): string
    {
        return sprintf('PO%06d/%s', $id, $finYear);
    }

    public function orderQty(): int
    {
        return (int) $this->items->sum('order_qty');
    }

    public function dueQty(): int
    {
        return (int) $this->items->sum(fn ($i) => $i->dueQty());
    }

    public function approvalCard(): array
    {
        $qty = (int) $this->items()->sum('order_qty');

        return ['purchase', 'New Purchase Order', $this->po_no, "Purchase order {$this->po_no} is pending QM approval.",
            array_values(array_filter([$this->po_no, $this->supplier?->name, "{$qty} pcs"])), $this->unit_id, route('inventory.purchase.purchaseorders.show', $this->id)];
    }
}
