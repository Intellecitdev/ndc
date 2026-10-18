<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Concerns\HandlesTickets;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    use HandlesTickets;

    public function index(Request $request): View
    {
        $tickets = $request->user()->tickets()
            ->with(['user', 'comments.user'])
            ->withCount('comments')
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($q) => $q
                ->where('subject', 'like', "%{$request->search}%")
                ->orWhere('details', 'like', "%{$request->search}%")))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('user.ticket', [
            'tickets' => $tickets,
            'unread' => $request->user()->tickets()->whereNull('read_at')->count(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->check($request, [
            'Subject' => ['required', 'string', 'max:250'],
            'Details' => ['required', 'string', 'max:5000'],
            'attchfile' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,pdf', 'max:5120'],
        ], ['attchfile' => 'Attachment']);

        $request->user()->tickets()->create([
            'subject' => $data['Subject'],
            'details' => $data['Details'],
            'attachment' => $request->file('attchfile')?->store('tickets', 'public'),
        ]);

        return $this->ok('Ticket created successfully.');
    }

    public function update(Request $request, Ticket $ticket): JsonResponse
    {
        abort_unless($ticket->user_id === $request->user()->id, 403);
        abort_if((int) $request->input('_form') === 1, 403); // only support staff mark tickets as read

        return $this->ticketAction($request, $ticket);
    }
}
