<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Ticket actions shared by Admin > Tickets and User > Ticket.
 * "_form" picks the action, as in the reference: 1 = mark as read, 2 = comment, 4 = close.
 */
trait HandlesTickets
{
    use JsonResponses;

    protected function ticketAction(Request $request, Ticket $ticket): JsonResponse
    {
        switch ((int) $request->input('_form')) {
            case 1:
                $ticket->update(['read_at' => $ticket->read_at ?? now()]);

                return $this->ok('Ticket marked as read.');

            case 2:
                $data = $this->check($request, ['Comments' => ['required', 'string', 'max:2000']]);
                $ticket->comments()->create(['user_id' => $request->user()->id, 'comments' => $data['Comments']]);

                return $this->ok('Comment added successfully.');

            case 4:
                if ($ticket->status === 'Closed') {
                    return $this->fail('Ticket is already closed.');
                }
                $data = $this->check($request, ['CloseNote' => ['required', 'string', 'max:2000']], ['CloseNote' => 'Close Note']);
                $ticket->update([
                    'status' => 'Closed',
                    'close_note' => $data['CloseNote'],
                    'closed_by' => $request->user()->id,
                    'closed_at' => now(),
                ]);

                return $this->ok('Ticket closed successfully.');
        }

        return $this->fail('Unknown action.');
    }
}
