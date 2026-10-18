<x-layouts.app title="Notification">
    <div x-data="{ readUrl: '' }">
        <x-card title="Notification" :back="route('welcome')">
            <x-search-form :action="route('user.notification.index')" />
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>SL</th><th>Subject</th><th>Message</th><th>Type</th><th>Sender</th><th>Send At</th><th>Read At</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($notifications as $n)
                        <tr>
                            <td>{{ $notifications->firstItem() + $loop->index }}</td>
                            <td class="!pl-[5px] !text-left">{{ $n->data['subject'] ?? '' }}</td>
                            <td class="!pl-[5px] !text-left">{{ $n->data['message'] ?? '' }}</td>
                            <td>{{ $n->data['type'] ?? 'Web' }}</td>
                            <td>{{ $n->data['sender'] ?? '' }}</td>
                            <td>{{ $n->created_at }}</td>
                            @if ($n->read_at)
                                <td>{{ $n->read_at }}</td>
                                <td></td>
                            @else
                                <td class="font-bold text-bs-warning">{{ $n->created_at->diffForHumans() }}</td>
                                <td>
                                    <button title="Mark as Read" class="btn btn-sm btn-info" @click="readUrl = @js(route('user.notification.update', $n->id)); $dispatch('open-modal', 'markasReadModal')"><i class="fa-solid fa-envelope-open"></i></button>
                                </td>
                            @endif
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $notifications->links() }}</x-slot:footer>
        </x-card>
        <x-confirm-modal name="markasReadModal" bind-action="readUrl" method="PATCH" title="Mark as Read" icon="fa-solid fa-pen-to-square"
                         message="Are you sure you want to mark as read this notification?" submit="Read" submit-class="btn-warning" submit-icon="fa-regular fa-square-check" />
    </div>
</x-layouts.app>
