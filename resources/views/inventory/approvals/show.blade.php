{{-- One approval request in full: the request (who/when/decision) and every detail of the record it is about. --}}
@php
    $statusBadge = match ($approval->status) {
        'Approved' => 'bg-emerald-100 text-emerald-800',
        'Rejected' => 'bg-red-100 text-red-700',
        default => 'bg-amber-100 text-amber-800',
    };
    $person = fn ($u) => $u ? trim($u->full_name.' ('.$u->name.')') : '';
@endphp
<x-layouts.app :title="$approval->title" module="inventory">
    <div>
        <x-card :title="'<i class=\'fa-solid fa-clipboard-check\'></i>&nbsp; '.e($approval->title).' &mdash; '.e($approval->reference)" :back="url()->previous() !== url()->current() ? url()->previous() : route('inventory.approvals.index')" class="mb-2">
            <x-slot:actions>
                @if ($canDecide)
                    <form x-data="ajaxForm" action="{{ route('inventory.approvals.approve', $approval) }}" @submit.prevent="submit">
                        <button type="submit" class="btn btn-success" :disabled="busy"><i class="fa-solid fa-check"></i>&nbsp; Approve</button>
                    </form>
                    <button type="button" class="btn btn-danger" @click="$dispatch('open-modal', 'rejectModal')"><i class="fa-solid fa-ban"></i>&nbsp; Reject</button>
                @endif
                @if ($recordUrl && $record?->isApproved())
                    <a href="{{ $recordUrl }}" class="btn btn-secondary"><i class="fa-solid fa-up-right-from-square"></i>&nbsp; Go to Record</a>
                @endif
            </x-slot:actions>

            <div class="mb-3 flex flex-wrap items-center gap-2">
                <span class="rounded-full px-3 py-1 text-[11px] font-bold tracking-wider {{ $statusBadge }}">{{ strtoupper($approval->status) }}</span>
                <span class="rounded-md bg-slate-100 px-2 py-1 text-[12px] font-semibold text-slate-600">{{ \App\Models\ApprovalRequest::CATEGORIES[$approval->category] ?? $approval->category }}</span>
                @foreach ($approval->chips ?? [] as $chip)
                    <span class="rounded-md bg-slate-100 px-2 py-1 text-[12px] font-semibold text-slate-600">{{ $chip }}</span>
                @endforeach
            </div>
            <p class="mb-3 text-[14px] text-slate-700">{{ $approval->message }}</p>

            <x-info-columns :columns="[
                ['Request Type' => $approval->title, 'Reference' => $approval->reference, 'Requested By' => $person($approval->requester),
                 'Requested At' => $approval->created_at->format('d M Y, h:i A')],
                ['Status' => $approval->status, 'Actioned By' => $person($approval->actioner),
                 'Actioned At' => $approval->actioned_at?->format('d M Y, h:i A'), 'Reason' => $approval->reason],
            ]" />
        </x-card>

        @if ($record && $partial)
            @include('inventory.approvals.details.'.$partial, ['record' => $record])
        @else
            <x-card title="Record Details">
                <p class="m-0 text-center text-slate-500">This record no longer exists.</p>
            </x-card>
        @endif

        @if ($canDecide)
            <x-modal name="rejectModal">
                <form x-data="ajaxForm" action="{{ route('inventory.approvals.reject', $approval) }}" @submit.prevent="submit">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa-solid fa-ban"></i>&nbsp; Reject {{ $approval->reference }}</h5>
                        <button type="button" class="btn-close" @click="$dispatch('close-modal', 'rejectModal')">&times;</button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label" for="RejectReason">Reason <span class="text-danger">*</span></label>
                        <textarea id="RejectReason" name="reason" rows="4" maxlength="1000" required class="form-control"
                                  placeholder="Why is this request rejected?"></textarea>
                        <p class="mt-2 mb-0 text-[13px] text-slate-500">The request will not be added to the inventory; the Storeman sees this reason.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="$dispatch('close-modal', 'rejectModal')">Close</button>
                        <button type="submit" class="btn btn-danger" :disabled="busy"><i class="fa-solid fa-ban"></i>&nbsp; Reject</button>
                    </div>
                </form>
            </x-modal>
        @endif
    </div>
</x-layouts.app>
