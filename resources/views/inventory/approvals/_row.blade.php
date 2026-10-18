{{--
 One queue line. $req = ApprovalRequest|null, $notification = unread notification id|null.
--}}
@php
    $pendingReq = $req && $req->isPending() && $canDecide;
    $statusBadge = match (true) {
        $badge === 'UNREAD' => 'bg-[#0b5a3c] text-white',
        $badge === 'APPROVED' => 'bg-emerald-100 text-emerald-800',
        $badge === 'REJECTED' => 'bg-red-100 text-red-700',
        default => 'bg-amber-100 text-amber-800',
    };
@endphp
<div @class(['flex flex-col gap-3 border-b border-slate-200 px-4 py-4 sm:px-7 lg:flex-row lg:items-center', 'bg-emerald-50/40' => $badge === 'UNREAD'])>
    <div class="min-w-0 flex-1">
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-[17px] font-bold text-slate-900">{{ $title }}</span>
            <span class="rounded-full px-2 py-0.5 text-[10px] font-bold tracking-wider {{ $statusBadge }}">{{ $badge }}</span>
        </div>
        <p class="mb-2 mt-1 text-[14px] text-slate-700">{{ $message }}</p>
        @if ($req?->reason)
            <p class="mb-2 text-[13px] text-red-700"><b>Reason:</b> {{ $req->reason }}</p>
        @endif
        <div class="flex flex-wrap items-center gap-2 text-[12px] font-semibold text-slate-500">
            @foreach ($req?->chips ?? [] as $chip)
                <span class="rounded-md bg-slate-100 px-2 py-1 text-slate-600">{{ $chip }}</span>
            @endforeach
            <span>{{ $time->format('d M Y, h:i A') }}</span>
            @if ($req?->requester)
                <span>&middot; by {{ $req->requester->full_name ?: $req->requester->name }}</span>
            @endif
        </div>
    </div>
    <div class="flex flex-wrap gap-2 lg:justify-end">
        @if ($pendingReq)
            <button type="button" :disabled="busy" class="rounded-md bg-[#123b2b] px-4 py-2 text-[13px] font-bold text-white hover:bg-[#0b5a3c]"
                    @click="post(@js(route('inventory.approvals.approve', $req)))">Approve</button>
            <button type="button" :disabled="busy" class="rounded-md bg-red-50 px-4 py-2 text-[13px] font-bold text-red-700 hover:bg-red-100"
                    @click="openReject(@js(route('inventory.approvals.reject', $req)), @js($req->reference))">Reject</button>
        @endif
        @if ($url)
            <a href="{{ $url }}" class="rounded-md border border-slate-300 bg-white px-4 py-2 no-underline text-[13px] font-bold text-slate-900 hover:bg-slate-50">Open</a>
        @endif
        @if ($notification)
            <button type="button" :disabled="busy" class="rounded-md bg-[#123b2b] px-4 py-2 text-[13px] font-bold text-white hover:bg-[#0b5a3c]"
                    @click="post(@js(route('inventory.approvals.read', $notification)))">Mark Read</button>
        @endif
    </div>
</div>
