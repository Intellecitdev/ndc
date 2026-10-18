{{-- Tabs + lists of the QM queue; re-rendered over AJAX (?partial=1) after every action. --}}
@php
    $tabs = ['unread' => ['Unread', $unreadCount]]
        + collect($categories)->map(fn ($label, $key) => [$label, ($pending[$key] ?? collect())->count()])->all()
        + ['read' => ['Read', $readCount]];
    $empty = '<div class="px-7 py-10 text-center text-[14px] text-slate-500">Nothing here right now.</div>';
    $noteRow = function ($n, $isUnread) use ($requests) {
        $req = $requests[$n->data['approval_id'] ?? 0] ?? null;
        $badge = $isUnread ? 'UNREAD' : ($req && ! $req->isPending() ? strtoupper($req->status) : 'READ');

        return ['title' => $n->data['subject'] ?? '', 'badge' => $badge, 'message' => $n->data['message'] ?? '', 'time' => $n->created_at,
            'req' => $req, 'url' => $req ? route('inventory.approvals.show', $req) : ($n->data['url'] ?? null), 'notification' => $isUnread ? $n->id : null];
    };
@endphp
<div data-queue-body>
    <div class="grid grid-cols-2 gap-3 border-b border-slate-200 px-4 py-4 sm:grid-cols-3 sm:px-7 xl:grid-cols-6">
        @foreach ($tabs as $key => [$label, $count])
            <button type="button" @click="tab = @js($key)"
                    :class="tab === @js($key) ? 'bg-[#0b5a3c] text-white border-[#0b5a3c]' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50'"
                    class="flex items-center justify-center gap-2 whitespace-nowrap rounded-full border px-3 py-3 text-[14px] font-bold transition">
                {{ $label }}
                <span :class="tab === @js($key) ? 'bg-white/20 text-white' : 'border border-slate-200 text-slate-700'"
                      class="min-w-7 rounded-full px-2 py-0.5 text-[12px]">{{ $count }}</span>
            </button>
        @endforeach
    </div>

    {{-- Notifications --}}
    @foreach (['unread' => $unread, 'read' => $read] as $key => $list)
        <div x-show="tab === @js($key)" @if ($key !== $tab) x-cloak @endif>
            <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50/60 px-4 py-3 sm:px-7">
                <span class="text-[14px] font-bold text-slate-900">{{ ucfirst($key) }} Notifications</span>
                @if ($key === 'unread' && $unreadCount)
                    <button type="button" :disabled="busy" class="rounded-md border border-slate-800 bg-white px-3 py-1.5 text-[12px] font-bold text-slate-900 hover:bg-slate-50"
                            @click="post(@js(route('inventory.approvals.read')))">Mark All Read</button>
                @endif
            </div>
            @forelse ($list as $n)
                @include('inventory.approvals._row', $noteRow($n, $key === 'unread'))
            @empty
                {!! $empty !!}
            @endforelse
        </div>
    @endforeach

    {{-- Pending requests by type --}}
    @foreach ($categories as $key => $label)
        <div x-show="tab === @js($key)" @if ($key !== $tab) x-cloak @endif>
            <div class="border-b border-slate-200 bg-slate-50/60 px-4 py-3 text-[14px] font-bold text-slate-900 sm:px-7">Pending {{ $label }}</div>
            @forelse ($pending[$key] ?? [] as $req)
                @include('inventory.approvals._row', ['title' => $req->title, 'badge' => 'PENDING', 'message' => $req->message, 'time' => $req->created_at,
                    'req' => $req, 'url' => route('inventory.approvals.show', $req), 'notification' => null])
            @empty
                {!! $empty !!}
            @endforelse
        </div>
    @endforeach
</div>
