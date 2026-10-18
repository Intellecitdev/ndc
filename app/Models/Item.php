<?php

namespace App\Models;

use App\Models\Concerns\MasterData;
use App\Models\Concerns\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use MasterData, RequiresApproval;

    protected $fillable = ['parent_category_id', 'category_id', 'brand_id', 'product_model_id', 'port_id', 'layer_id', 'capacity_id', 'item_unit_id', 'code', 'name', 'description', 'has_warranty', 'is_consumable', 'is_license', 'status'];

    protected $casts = ['has_warranty' => 'boolean', 'is_consumable' => 'boolean', 'is_license' => 'boolean'];

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(ParentCategory::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function productModel(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class);
    }

    public function port(): BelongsTo
    {
        return $this->belongsTo(Port::class);
    }

    public function layer(): BelongsTo
    {
        return $this->belongsTo(Layer::class);
    }

    public function capacity(): BelongsTo
    {
        return $this->belongsTo(Capacity::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(ItemUnit::class, 'item_unit_id');
    }

    /**
     * Current "In Stock" quantity per item id: [item_id => qty].
     */
    public static function stockFor(array $ids): array
    {
        return Stock::inStock()->whereIn('item_id', $ids)->groupBy('item_id')
            ->selectRaw('item_id, sum(quantity) qty')->pluck('qty', 'item_id')->map(fn ($q) => (int) $q)->all();
    }

    /**
     * "Item Statistics.." block of the item detail page.
     */
    public function statistics(): array
    {
        $stockIds = Stock::where('item_id', $this->id)->pluck('id');
        $voucherItems = IssueVoucherItem::whereIn('stock_id', $stockIds);

        return [
            'Current Stock' => static::stockFor([$this->id])[$this->id] ?? 0,
            'Unit Demands' => 0,
            'Demand Purchase' => 0,
            'Purchase Orders' => PurchaseOrderItem::where('item_id', $this->id)->sum('order_qty'),
            'Order Received' => PurchaseReceiveItem::where('item_id', $this->id)->sum('quantity'),
            'Stock Receive' => (clone $voucherItems)->where('status', 'Received')->sum('quantity'),
            'Deployments' => Deployment::whereIn('stock_id', $stockIds)->sum('quantity'),
            'Issue Voucher' => (clone $voucherItems)->sum('quantity'),
            'Damages' => Damage::whereIn('stock_id', $stockIds)->sum('quantity'),
            'Transactions' => $stockIds->count(),
        ];
    }

    public function approvalCard(): array
    {
        return ['material', 'New Item', $this->code, "Item {$this->code} - {$this->name} is pending QM approval.",
            array_values(array_filter([$this->code, $this->category?->name, $this->brand?->name])), null, route('inventory.configuration.items.show', $this->id)];
    }
}
