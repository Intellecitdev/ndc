<?php

namespace App\Models;

use App\Models\Concerns\MasterData;
use App\Models\Concerns\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use MasterData, RequiresApproval;

    protected $fillable = ['category_id', 'name', 'description', 'status'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function models(): HasMany
    {
        return $this->hasMany(ProductModel::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function approvalCard(): array
    {
        return ['material', 'New Brand', $this->name, "Brand {$this->name} is pending QM approval.",
            array_values(array_filter([$this->name, $this->category?->name])), null, route('inventory.configuration.brands.show', $this->id)];
    }
}
