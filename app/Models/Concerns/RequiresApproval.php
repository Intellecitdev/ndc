<?php

namespace App\Models\Concerns;

use App\Models\ApprovalRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

/**
 * Records a Storeman creates wait as "Pending" for the Quarter Master: the
 * approval request (and the QM's real-time notification) is raised once the
 * surrounding transaction commits, so lines/stock rows are already there.
 * Users who may approve (and the seeders) create records that are approved.
 *
 * The model describes itself for the queue with approvalCard().
 */
trait RequiresApproval
{
    public const PENDING = 'Pending';
    public const APPROVED = 'Approved';
    public const REJECTED = 'Rejected';

    protected static function bootRequiresApproval(): void
    {
        static::creating(function ($model) {
            $model->approval_status ??= auth()->user()?->needsApproval() ? self::PENDING : self::APPROVED;
        });

        static::created(function ($model) {
            if ($model->isPending()) {
                DB::afterCommit(fn () => ApprovalRequest::raise($model));
            }
        });

        static::deleting(fn ($model) => $model->approvalRequests()->delete());
    }

    public function initializeRequiresApproval(): void
    {
        $this->mergeFillable(['approval_status']);
    }

    public function approvalRequests(): MorphMany
    {
        return $this->morphMany(ApprovalRequest::class, 'approvable');
    }

    public function scopeApproved($query)
    {
        return $query->where($this->getTable().'.approval_status', self::APPROVED);
    }

    public function isPending(): bool
    {
        return $this->approval_status === self::PENDING;
    }

    public function isApproved(): bool
    {
        return ($this->approval_status ?? self::APPROVED) === self::APPROVED;
    }

    /** Side effects of an approval (stock goes live, receivers are told...). */
    public function onApproved(): void {}

    /** Undo whatever the pending record reserved, so nothing reaches the inventory. */
    public function onRejected(): void {}

    /**
     * How the request shows in the QM queue:
     * [category, title, reference, message, chips[], unit_id|null, url].
     */
    abstract public function approvalCard(): array;
}
