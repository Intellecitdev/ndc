<?php

namespace App\Models;

use App\Notifications\ApprovalNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

/**
 * A Storeman request waiting for (or decided by) the Quarter Master.
 */
class ApprovalRequest extends Model
{
    public const CATEGORIES = [
        'material' => 'Materials',
        'purchase' => 'Purchase Orders',
        'stock' => 'Stock Entries',
        'issue' => 'Issue Requests',
    ];

    protected $fillable = ['approvable_type', 'approvable_id', 'category', 'unit_id', 'title', 'reference', 'message', 'chips', 'status', 'reason', 'requested_by', 'actioned_by', 'actioned_at'];

    protected $casts = ['chips' => 'array', 'actioned_at' => 'datetime'];

    public function approvable(): MorphTo
    {
        return $this->morphTo();
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function actioner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actioned_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'Pending';
    }

    /** Requests an approver may act on: their own wing's, plus shared master data. */
    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $user->isSuperAdmin()
            ? $query
            : $query->where(fn ($q) => $q->whereNull('unit_id')->orWhere('unit_id', $user->unit_id));
    }

    public function visibleTo(User $user): bool
    {
        return $user->isSuperAdmin() || $this->unit_id === null || $this->unit_id === $user->unit_id;
    }

    /**
     * Queue a pending record and tell the approvers (real-time toast via the header poll).
     */
    public static function raise(Model $record): self
    {
        [$category, $title, $reference, $message, $chips, $unitId, $url] = $record->approvalCard();
        $requester = auth()->user();

        $request = static::create([
            'approvable_type' => $record->getMorphClass(), 'approvable_id' => $record->getKey(),
            'category' => $category, 'unit_id' => $unitId, 'title' => $title, 'reference' => $reference,
            'message' => $message, 'chips' => $chips, 'requested_by' => $requester?->id,
        ]);

        Notification::send(
            User::approvers($unitId)->reject(fn ($u) => $u->id === $requester?->id),
            new ApprovalNotification($request, $title, $message, $requester)
        );

        return $request;
    }

    public function approve(User $by): void
    {
        $this->decide($by, 'Approved');
    }

    public function reject(User $by, string $reason): void
    {
        $this->decide($by, 'Rejected', $reason);
    }

    private function decide(User $by, string $status, ?string $reason = null): void
    {
        DB::transaction(function () use ($by, $status, $reason) {
            $record = $this->approvable;
            $record->update(['approval_status' => $status]);
            $status === 'Approved' ? $record->onApproved() : $record->onRejected();
            $this->update(['status' => $status, 'reason' => $reason, 'actioned_by' => $by->id, 'actioned_at' => now()]);
        });

        // The approval notifications other approvers got are done with.
        DB::table('notifications')->whereNull('read_at')->where('type', ApprovalNotification::class)
            ->where('data->approval_id', $this->id)->update(['read_at' => now()]);

        if ($this->requester && $this->requester->id !== $by->id) {
            $this->requester->notify(new ApprovalNotification(
                $this,
                preg_replace('/^New /', '', $this->title)." {$status}",
                $this->reference.' was '.strtolower($status).' by '.($by->full_name ?: $by->name).($reason ? ". Reason: {$reason}" : '.'),
                $by,
                decision: true,
            ));
        }
    }
}
