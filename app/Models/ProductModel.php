<?php

namespace App\Models;

use App\Models\Concerns\MasterData;
use App\Models\Concerns\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductModel extends Model
{
    use MasterData, RequiresApproval;

    protected $table = 'product_models';
    protected $fillable = ['category_id', 'brand_id', 'name', 'status'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function ports(): HasMany
    {
        return $this->hasMany(Port::class);
    }

    public function layers(): HasMany
    {
        return $this->hasMany(Layer::class);
    }

    public function capacities(): HasMany
    {
        return $this->hasMany(Capacity::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function approvalCard(): array
    {
        return ['material', 'New Model', $this->name, "Model {$this->name} is pending QM approval.",
            array_values(array_filter([$this->name, $this->brand?->name, $this->category?->name])), null, route('inventory.configuration.models.show', $this->id)];
    }
}
