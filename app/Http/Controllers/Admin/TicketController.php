<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesTickets;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TicketController extends Controller
{
    use HandlesTickets;

    public function index(Request $request): View
    {
        $tickets = Ticket::with(['user', 'comments.user'])
            ->withCount('comments')
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($q) => $q
                ->where('subject', 'like', "%{$request->search}%")
                ->orWhere('details', 'like', "%{$request->search}%")))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.messaging.tickets', compact('tickets'));
    }

    public function update(Request $request, Ticket $ticket): JsonResponse
    {
        return $this->ticketAction($request, $ticket);
    }

    public function destroy(Ticket $ticket): JsonResponse
    {
        if ($ticket->attachment) {
            Storage::disk('public')->delete($ticket->attachment);
        }
        $ticket->delete();

        return $this->ok('Ticket deleted successfully.', ['id' => $ticket->id]);
    }
}
