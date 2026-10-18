{{--
  Shared by Admin > Tickets and User > Ticket.
  $tickets, $updateRoute (route name), $isAdmin, $canDelete
--}}
<div x-data="{ t: {}, deleteUrl: '' }">
    <div class="table-responsive">
        <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
            <thead>
            <tr>
                <th>ID</th><th>Subject</th><th>Details</th><th>Attachments</th><th>Sender</th><th>Send At</th><th>Read At</th>
                @if ($isAdmin)<th>Status</th>@endif
                <th>#Reply</th><th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($tickets as $ticket)
                @php
                    $data = [
                        'url' => route($updateRoute, $ticket),
                        'subject' => $ticket->subject,
                        'status' => $ticket->status,
                        'close_note' => $ticket->close_note,
                        'file' => $ticket->attachment ? route('attachments.ticket', $ticket) : null,
                        'pdf' => $ticket->attachment && str_ends_with(strtolower($ticket->attachment), '.pdf'),
                        'comments' => $ticket->comments->map(fn ($c) => ['by' => $c->user?->full_name, 'at' => (string) $c->created_at, 'text' => $c->comments])->all(),
                    ];
                @endphp
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td class="!text-left">{{ $ticket->subject }}</td>
                    <td class="!text-left">{{ $ticket->details }}</td>
                    <td>
                        @if ($ticket->attachment)
                            <button type="button" class="btn btn-sm btn-outline-secondary" title="Attachment View"
                                    @click="t = @js($data); $dispatch('open-modal', 'attachmentModal')"><i class="fa-solid fa-paperclip"></i></button>
                        @endif
                    </td>
                    <td>{{ $ticket->user?->full_name }}</td>
                    <td>{{ $ticket->created_at }}</td>
                    <td class="{{ $ticket->read_at ? '' : 'text-bs-warning font-bold' }}">{{ $ticket->read_at ?? 'Unread' }}</td>
                    @if ($isAdmin)
                        <td><span class="badge {{ $ticket->status === 'Closed' ? 'text-bg-secondary' : 'text-bg-success' }}">{{ $ticket->status }}</span></td>
                    @endif
                    <td>{{ $ticket->comments_count }}</td>
                    <td>
                        <div class="flex justify-center gap-1">
                            @if ($isAdmin && ! $ticket->read_at)
                                <button title="Mark as Read" class="btn btn-sm btn-info" @click="t = @js($data); $dispatch('open-modal', 'markasReadModal')"><i class="fa-solid fa-envelope-open"></i></button>
                            @endif
                            <button title="Comments" class="btn btn-sm btn-primary" @click="t = @js($data); $dispatch('open-modal', 'commentsModal')"><i class="fa-regular fa-comments"></i></button>
                            @if ($ticket->status !== 'Closed')
                                <button title="Close Ticket" class="btn btn-sm btn-warning" @click="t = @js($data); $dispatch('open-modal', 'closeModal')"><i class="fa-solid fa-lock"></i></button>
                            @endif
                            @if ($canDelete)
                                <button title="Delete" class="btn btn-sm btn-danger" @click="deleteUrl = @js(route('admin.messaging.tickets.destroy', $ticket)); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-2">{{ $tickets->links() }}</div>

    <x-confirm-modal name="markasReadModal" bind-action="t.url" method="PATCH" title="Mark as Read" icon="fa-solid fa-pen-to-square" :message="'Are you sure you want to mark as read this '.($isAdmin ? 'tickets' : 'ticket').'?'" submit="Read" submit-class="btn-warning" submit-icon="fa-regular fa-square-check">
        <input type="hidden" name="_form" value="1">
    </x-confirm-modal>

    <x-modal-form name="commentsModal" :title="$isAdmin ? 'Comments on Tickets' : 'Comments on Ticket'" icon="fa-regular fa-comment-dots" bind-action="t.url" method="PATCH" submit="Sent" submit-icon="fa-solid fa-paper-plane" size="max-w-[800px]">
        <input type="hidden" name="_form" value="2">
        <p class="mb-2 font-bold" x-text="t.subject"></p>
        <div class="mb-3 max-h-[250px] overflow-y-auto">
            <template x-for="c in t.comments" :key="c.at + c.text">
                <div class="mb-2 rounded border border-bs-border p-2">
                    <div class="text-sm text-bs-secondary"><b x-text="c.by"></b> &middot; <span x-text="c.at"></span></div>
                    <div x-text="c.text"></div>
                </div>
            </template>
            <p x-show="! t.comments?.length" class="text-bs-secondary">No comments yet.</p>
            <p x-show="t.close_note" class="alert alert-warning !mb-0">Closed: <span x-text="t.close_note"></span></p>
        </div>
        <template x-if="t.status !== 'Closed'">
            <x-form.input label="Comments" name="Comments" type="textarea" rows="10" required />
        </template>
    </x-modal-form>

    <x-modal-form name="closeModal" title="Close Ticket" icon="fa-regular fa-square-minus" bind-action="t.url" method="PATCH" submit="Update" submit-class="btn-warning" submit-icon="fa-regular fa-floppy-disk">
        <input type="hidden" name="_form" value="4">
        <x-form.input label="Close Note" name="CloseNote" type="textarea" rows="10" required />
    </x-modal-form>

    <x-modal name="attachmentModal" size="max-w-[900px]">
        <div class="modal-header">
            <h5 class="modal-title" x-text="(t.subject ?? '') + ' > Attachment View'"></h5>
            <button type="button" class="btn-close" @click="show = false">&times;</button>
        </div>
        <div class="modal-body text-center">
            <template x-if="t.pdf"><iframe :src="t.file" class="h-[70vh] w-full"></iframe></template>
            <template x-if="! t.pdf"><img :src="t.file" class="mx-auto max-h-[70vh]" alt=""></template>
        </div>
    </x-modal>

    @if ($canDelete)
        <x-delete-modal entity="ticket" />
    @endif
</div>
