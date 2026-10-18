<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Picqer\Barcode\BarcodeGeneratorPNG;

/**
 * Stock register row: one serial-numbered unit, or a quantity of a consumable.
 */
class Stock extends Model
{
    use Audited;

    /** Received on a stock entry the QM has not approved yet. */
    public const PENDING = 'Pending';
    public const IN_STOCK = 'In Stock';
    public const TRANSFERRED = 'Transferred';
    public const DEPLOYED = 'Deployed';
    public const DAMAGE = 'Damage';
    public const UNDER_WARRANTY = 'Under Warranty';
    public const UNDER_SERVICE = 'Under Service';

    /** Stock Position "type" filter (values as in the reference). */
    public const TYPES = [1 => self::TRANSFERRED, 1001 => self::DEPLOYED, 1002 => self::DAMAGE, 1003 => self::UNDER_WARRANTY, 1004 => self::UNDER_SERVICE];

    protected $fillable = [
        'unit_id', 'item_id', 'purchase_receive_id', 'purchase_receive_item_id', 'supplier_id', 'parent_id', 'serial_no', 'quantity', 'status',
        'coverage_type', 'coverage_start', 'duration', 'duration_type', 'coverage_end', 'coverage_terms',
    ];

    protected $casts = ['coverage_start' => 'date', 'coverage_end' => 'date'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseReceive(): BelongsTo
    {
        return $this->belongsTo(PurchaseReceive::class);
    }

    public function purchaseReceiveItem(): BelongsTo
    {
        return $this->belongsTo(PurchaseReceiveItem::class);
    }

    public function deployments(): HasMany
    {
        return $this->hasMany(Deployment::class);
    }

    public function scopeInStock($query)
    {
        return $query->where('stocks.status', self::IN_STOCK);
    }

    /**
     * Only stock a wing received through an issue voucher is deployed to personnel;
     * the purchasing store issues it instead (the reference hides Deploy there).
     */
    public function canDeploy(): bool
    {
        return $this->status === self::IN_STOCK
            && (! $this->purchase_receive_id || $this->unit_id !== $this->purchaseReceive?->unit_id);
    }

    /** Serial number, or the item code for consumables without one. */
    public function label(): string
    {
        return $this->serial_no ?? $this->item?->code ?? '';
    }

    public function statusBadge(): string
    {
        return match ($this->status) {
            self::IN_STOCK => 'text-bg-success',
            self::TRANSFERRED => 'text-bg-info',
            self::DEPLOYED => 'text-bg-primary',
            self::DAMAGE => 'text-bg-danger',
            default => 'text-bg-warning',
        };
    }

    public function coverageInfo(): string
    {
        return $this->coverage_start ? $this->coverage_start->format('d-m-Y').' To '.$this->coverage_end?->format('d-m-Y') : '';
    }

    /** Data for the "Show Stock Details" modal. */
    public function details(): array
    {
        return [
            'category' => $this->item?->category?->name, 'name' => $this->item?->name, 'model' => $this->item?->productModel?->name,
            'serial' => $this->label(), 'date' => $this->created_at?->format('d-m-Y'), 'type' => $this->coverage_type,
            'info' => $this->coverageInfo(), 'barcode' => $this->barcodeDataUri(),
        ];
    }

    public function barcodeDataUri(): string
    {
        $png = (new BarcodeGeneratorPNG)->getBarcode($this->label(), BarcodeGeneratorPNG::TYPE_CODE_128, 2, 30);

        return 'data:image/png;base64,'.base64_encode($png);
    }

    /**
     * Take $qty out of this row: the whole row when it is all of it, otherwise
     * a new row split off with that quantity. Returns the row that moves on.
     */
    public function take(int $qty, string $status): self
    {
        if ($qty >= $this->quantity) {
            $this->update(['status' => $status]);

            return $this;
        }

        $this->decrement('quantity', $qty);

        return static::create(array_merge($this->only($this->fillable), [
            'parent_id' => $this->id, 'serial_no' => null, 'quantity' => $qty, 'status' => $status,
        ]));
    }

    public static function coverageEnd(string $start, int $duration, string $type): string
    {
        $date = \Illuminate\Support\Carbon::parse($start);

        $end = match ($type) {
            'Days' => $date->addDays($duration),
            'Months' => $date->addMonths($duration),
            default => $date->addYears($duration),
        };

        return $end->toDateString();
    }
}
