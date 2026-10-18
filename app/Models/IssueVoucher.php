<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use App\Models\Concerns\RequiresApproval;
use App\Notifications\SystemNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Notification;

class IssueVoucher extends Model
{
    use Audited, RequiresApproval;

    protected $fillable = ['iv_no', 'date', 'from_unit_id'];

    protected $casts = ['date' => 'date'];

    public function items(): HasMany
    {
        return $this->hasMany(IssueVoucherItem::class);
    }

    public function fromUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'from_unit_id');
    }

    /** IV-00000001 */
    public static function makeNumber(int $id): string
    {
        // Sequential like the reference (its voucher #11 is IV-00000001), independent of the row id.
        return sprintf('IV-%08d', static::where('id', '<=', $id)->count());
    }

    public function approvalCard(): array
    {
        $items = $this->items()->with('toUnit')->get();
        $wings = $items->pluck('toUnit.name')->filter()->unique()->implode(', ');

        return ['issue', 'New Issuance Request', $this->iv_no, "Issuance {$this->iv_no} is pending QM approval.",
            array_values(array_filter([$this->iv_no, $items->count().' item(s)', $wings ? "To: {$wings}" : null])), $this->from_unit_id,
            route('inventory.transaction.issuevouchers.index', ['Code' => $this->iv_no])];
    }

    public function onApproved(): void
    {
        $this->notifyReceivers();
    }

    /** The reserved stock goes back on the shelf. */
    public function onRejected(): void
    {
        Stock::whereIn('id', $this->items()->pluck('stock_id'))->where('status', Stock::TRANSFERRED)->update(['status' => Stock::IN_STOCK]);
    }

    /** Tell the receiving wings (real-time toast via the header poll). */
    public function notifyReceivers(): void
    {
        foreach ($this->items()->get()->groupBy('to_unit_id') as $unitId => $lines) {
            $receivers = User::where('unit_id', $unitId)->where('status', true)->get()
                ->filter(fn ($u) => $u->canMenu('inventory/transaction/stockreceive'));
            Notification::send($receivers, new SystemNotification(
                "Stock issued: {$this->iv_no}",
                count($lines).' item(s) issued to your wing are waiting in Stock Receive.',
                $this->creator ?? auth()->user()
            ));
        }
    }
}
