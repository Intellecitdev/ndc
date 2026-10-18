<x-layouts.app title="Chats" module="admin">
    <div class="grid grid-cols-1 gap-x-6 md:grid-cols-12" x-data="{ deleteUrl: '' }">
        <div class="md:col-span-3">
            <x-card title="User List" :back="route('welcome')">
                <div class="max-h-[500px] min-h-[300px] overflow-x-auto">
                    <form method="GET" action="{{ route('admin.messaging.chats.index') }}" class="mb-2">
                        <x-form.select label="Sender" name="senderid" :options="$users" placeholder="Sender Name" :selected="request('senderid')" />
                        <x-form.select label="Receiver" name="receiverid" :options="$users" placeholder="Receiver Name" :selected="request('receiverid')" />
                        <button class="btn btn-primary" type="submit">Preview</button>
                    </form>
                </div>
            </x-card>
        </div>
        <div class="md:col-span-9">
            @if ($chats === null)
                <x-card title="Chats Details" :back="route('welcome')">
                    <div class="min-h-[300px]"><p class="text-primary">Select Sender and Reciver to preview chats details...</p></div>
                </x-card>
            @else
                <x-card :title="'Chats Details between <strong>'.e($sender->full_name).'</strong> and <strong>'.e($receiver->full_name).'</strong>'" :back="route('admin.messaging.chats.index')">
                    <x-slot:actions>
                        <a href="{{ route('admin.messaging.chats.pdf', ['senderid' => $sender->id, 'receiverid' => $receiver->id]) }}" class="btn btn-secondary" target="_blank"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                    </x-slot:actions>
                    <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                        <thead><tr><th class="w-[19%]">From</th><th class="w-[7%]">Priority</th><th class="w-1/2">Message</th><th class="w-[17%]">Created At</th><th class="w-[7%]">Status</th><th>Action</th></tr></thead>
                        <tbody>
                        @forelse ($chats as $chat)
                            <tr>
                                <td>{{ $chat->sender?->full_name }}</td>
                                <td class="{{ $chat->priorityClass() }}">{{ $chat->priority }}</td>
                                <td class="!text-left !pl-2.5 {{ $chat->sender_id === $sender->id ? 'text-[green]' : 'text-bs-primary' }}">{{ $chat->message }}</td>
                                <td>{{ $chat->created_at }}</td>
                                <td>@if ($chat->read_at)<i class="fa-solid fa-check-double text-bs-primary" title="Seen {{ $chat->read_at }}"></i>@else -- @endif</td>
                                <td>
                                    @canmenu('admin/messaging/chats', 'delete')
                                        <button title="Delete" class="btn btn-sm btn-danger" @click="deleteUrl = @js(route('admin.messaging.chats.destroy', $chat)); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                                    @endcanmenu
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6">No messages found.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </x-card>
            @endif
        </div>
        <x-delete-modal entity="message" />
    </div>
</x-layouts.app>
