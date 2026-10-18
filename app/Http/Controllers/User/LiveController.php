<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\TicketComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Polled by the header every few seconds: current badge counts plus anything
 * that arrived since the last poll, so the page can pop a toast in real time.
 */
class LiveController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();
        $since = $request->filled('since') ? Carbon::createFromTimestamp((int) $request->since, config('app.timezone')) : now();

        $newNotifications = $user->unreadNotifications()->where('created_at', '>', $since)->get()
            ->map(fn ($n) => isset($n->data['approval_id'])
                // QM approval queue: the request itself, or the decision on one's own request.
                ? ['type' => str_ends_with($n->data['subject'], 'Rejected') ? 'error' : 'warning', 'title' => $n->data['subject'], 'message' => $n->data['message'], 'url' => $n->data['url'] ?? route('user.notification.index'), 'approval' => true]
                : ['type' => 'info', 'title' => 'Notification: '.($n->data['sender'] ?? ''), 'message' => $n->data['subject'] ?? '', 'url' => route('user.notification.index')]);

        $newChats = Chat::with('sender')->where('receiver_id', $user->id)->whereNull('read_at')->where('created_at', '>', $since)->get()
            ->map(fn ($c) => ['type' => $c->priority === 'H' ? 'error' : 'success', 'title' => 'Message from '.$c->sender?->full_name, 'message' => Str::limit($c->message, 80), 'url' => route('user.chat.show', $c->sender_id)]);

        $newReplies = TicketComment::with(['user', 'ticket'])
            ->whereHas('ticket', fn ($q) => $q->where('user_id', $user->id))
            ->where('user_id', '!=', $user->id)
            ->where('created_at', '>', $since)->get()
            ->map(fn ($c) => ['type' => 'warning', 'title' => 'Ticket reply: '.Str::limit($c->ticket->subject, 30), 'message' => Str::limit($c->comments, 80), 'url' => route('user.ticket.index')]);

        return response()->json([
            'now' => now()->getTimestamp(),
            'counts' => [
                'notifications' => $user->unreadNotifications()->count(),
                'messages' => Chat::where('receiver_id', $user->id)->whereNull('read_at')->count(),
                'tickets' => $user->tickets()->where('status', 'Open')->count(),
            ],
            'events' => $newNotifications->concat($newChats)->concat($newReplies)->values(),
        ]);
    }
}
