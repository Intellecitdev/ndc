@forelse ($chats as $chat)
    @php $mine = $chat->sender_id === $me->id; @endphp
    <tr>
        <td>{{ $mine ? 'Me' : $chat->sender?->full_name }}</td>
        <td class="{{ $chat->priorityClass() }}">{{ $chat->priority }}</td>
        <td class="!pl-2.5 !text-left {{ $mine ? 'text-[green]' : 'text-bs-primary' }}" title="{{ $chat->created_at }}">{{ $chat->message }}</td>
        <td>
            @if ($mine && $chat->read_at)
                <i class="fa-solid fa-check-double text-bs-primary" title="Seen {{ $chat->read_at }}"></i>
            @else
                --
            @endif
        </td>
    </tr>
@empty
    <tr><td colspan="4">No messages yet.</td></tr>
@endforelse
