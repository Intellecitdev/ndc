<?php

namespace App\Models;

use App\Models\Concerns\MasterData;
use App\Models\Concerns\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use MasterData, RequiresApproval;

    protected $fillable = ['parent_category_id', 'name', 'description', 'status'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ParentCategory::class, 'parent_category_id');
    }

    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
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
        return ['material', 'New Category', $this->name, "Category {$this->name} is pending QM approval.",
            array_values(array_filter([$this->name, $this->parent?->name])), null, route('inventory.configuration.categories.show', $this->id)];
    }
}
