<?php

namespace App\Models;

use App\Models\Concerns\MasterData;
use App\Models\Concerns\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParentCategory extends Model
{
    use MasterData, RequiresApproval;

    protected $fillable = ['name', 'status'];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function approvalCard(): array
    {
        return ['material', 'New Parent Category', $this->name, "Parent category {$this->name} is pending QM approval.",
            [$this->name], null, url('inventory/configuration/parentcategories')];
    }
}
