<?php

namespace App\Models\Concerns;

/**
 * Configuration records: audited, with an Active/Inactive status flag.
 */
trait MasterData
{
    use Audited;

    public function initializeMasterData(): void
    {
        $this->mergeCasts(['status' => 'boolean']);
    }

    /** Usable in dropdowns: active, and approved by the QM when the record needs approval. */
    public function scopeActive($query)
    {
        return $query->where($this->getTable().'.status', true)
            ->when(method_exists($this, 'scopeApproved'), fn ($q) => $q->approved());
    }

    public function statusLabel(): string
    {
        return $this->status ? 'Active' : 'Inactive';
    }
}
