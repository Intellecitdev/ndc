{{-- QM Notification Center (Approvals page and the inventory dashboard). --}}
<div x-data="approvalQueue(@js(route('inventory.approvals.index')), @js($tab))"
     class="mb-4 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-col gap-3 border-b border-slate-200 px-4 pb-5 pt-6 sm:flex-row sm:items-start sm:justify-between sm:px-7">
        <div>
            <div class="text-[11px] font-bold uppercase tracking-[.18em] text-[#0b5a3c]">QM Notification Center</div>
            <h2 class="mb-1 mt-1 text-[24px] font-bold text-slate-900">Approval Command Queue</h2>
            <p class="m-0 text-[14px] text-slate-600">Approve, reject or open requests &mdash; switch tabs instantly.</p>
        </div>
        <span class="inline-flex items-center gap-2 self-start rounded-full border border-slate-200 px-4 py-2 text-[11px] font-bold tracking-[.14em] text-[#0b5a3c] shadow-sm">
            <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-500"></span> LIVE QUEUE
        </span>
    </div>

    @include('inventory.approvals._queue')

    <x-modal name="rejectModal">
        <form @submit.prevent="post(reject.url, { reason: reject.reason })">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-ban"></i>&nbsp; Reject <span x-text="reject.reference"></span></h5>
                <button type="button" class="btn-close" @click="$dispatch('close-modal', 'rejectModal')">&times;</button>
            </div>
            <div class="modal-body">
                <label class="form-label" for="RejectReason">Reason <span class="text-danger">*</span></label>
                <textarea id="RejectReason" x-model="reject.reason" rows="4" maxlength="1000" required class="form-control"
                          placeholder="Why is this request rejected?"></textarea>
                <p class="mt-2 mb-0 text-[13px] text-slate-500">The request will not be added to the inventory; the Storeman sees this reason.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="reject.url = ''; $dispatch('close-modal', 'rejectModal')">Close</button>
                <button type="submit" class="btn btn-danger" :disabled="busy"><i class="fa-solid fa-ban"></i>&nbsp; Reject</button>
            </div>
        </form>
    </x-modal>
</div>
