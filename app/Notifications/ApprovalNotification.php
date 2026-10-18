<?php

namespace App\Notifications;

use App\Models\ApprovalRequest;
use App\Models\User;
use Illuminate\Notifications\Notification;

/**
 * To the approvers: a new request is waiting. To the requester ($decision): it was approved/rejected.
 * Stored like Admin > Messaging notifications (subject/message/sender), so it shows in the bell too.
 */
class ApprovalNotification extends Notification
{
    public function __construct(
        public ApprovalRequest $request,
        public string $subject,
        public string $message,
        public ?User $sender,
        public bool $decision = false,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'subject' => $this->subject,
            'message' => $this->message,
            'type' => $this->decision ? 'Approval Decision' : 'Approval',
            'sender_id' => $this->sender?->id,
            'sender' => $this->sender?->name ?? 'System',
            'approval_id' => $this->request->id,
            'category' => $this->request->category,
            'url' => $this->decision ? $this->request->approvable?->approvalCard()[6] : route('inventory.approvals.show', $this->request),
        ];
    }
}
