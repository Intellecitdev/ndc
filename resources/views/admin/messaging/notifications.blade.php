@php $p = 'admin/messaging/notifications'; @endphp
<x-layouts.app title="Notifications" module="admin">
    <div x-data="{ deleteUrl: '' }">
        <x-card title="Notifications" :back="route('admin.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="$dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; New Notification</button>
                @endcanmenu
            </x-slot:actions>
            <x-search-form :action="route('admin.messaging.notifications.index')" />
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>SL</th><th>Subject</th><th>Message</th><th>Type</th><th>Sender</th><th>Receiver</th><th>Send At</th><th>Read At</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($notifications as $n)
                        <tr>
                            <td>{{ $notifications->firstItem() + $loop->index }}</td>
                            <td class="!pl-[5px] !text-left">{{ $n->data['subject'] ?? '' }}</td>
                            <td class="!pl-[5px] !text-left">{{ $n->data['message'] ?? '' }}</td>
                            <td>{{ $n->data['type'] ?? 'Web' }}</td>
                            <td>{{ $n->data['sender'] ?? '' }}</td>
                            <td>{{ $n->notifiable?->name }}</td>
                            <td>{{ $n->created_at }}</td>
                            @if ($n->read_at)
                                <td>{{ $n->read_at }}</td>
                            @else
                                <td class="font-bold text-bs-warning">{{ $n->created_at->diffForHumans() }}</td>
                            @endif
                            <td>
                                @canmenu($p, 'delete')
                                    <button title="Delete" class="btn btn-sm btn-danger" @click="deleteUrl = @js(route('admin.messaging.notifications.destroy', $n->id)); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                                @endcanmenu
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $notifications->links() }}</x-slot:footer>
        </x-card>

        <x-modal-form name="addModal" title="New Notification" icon="fa-regular fa-bell" :action="route('admin.messaging.notifications.store')" submit="Sent" submit-icon="fa-solid fa-paper-plane" size="max-w-[800px]">
            <div class="grid grid-cols-1 gap-x-4 md:grid-cols-12">
                <div class="md:col-span-7">
                    <x-form.input label="Subject (*)" name="Subject" placeholder="Subject" maxlength="250" required />
                    <x-form.input label="Message (*)" name="Message" placeholder="Message" type="textarea" rows="10" required />
                </div>
                <div class="md:col-span-5">
                    <label class="form-label">Receivers (*)</label>
                    <div class="max-h-[550px] overflow-y-auto">
                        <table class="table table-bordered table-striped !m-0 [&_td]:!py-1">
                            <tbody>
                            <tr><td>
                                <button type="button" class="btn btn-sm btn-outline-secondary" @click="$root.querySelectorAll('.subscriber').forEach(c => c.checked = true)">Check All</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-sm btn-outline-secondary" @click="$root.querySelectorAll('.subscriber').forEach(c => c.checked = false)">Uncheck All</button>
                            </td></tr>
                            @foreach ($users as $u)
                                <tr><td><input type="checkbox" class="subscriber" id="subscribers{{ $u->id }}" name="subscribers[]" value="{{ $u->id }}"> <label class="cursor-pointer" for="subscribers{{ $u->id }}">{{ $u->full_name }}</label></td></tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </x-modal-form>

        <x-delete-modal entity="notification" />
    </div>
</x-layouts.app>
