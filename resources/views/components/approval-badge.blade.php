@props(['record'])
{{-- Shown next to the status while a Storeman's record waits for (or was refused by) the QM. --}}
@if ($record->approval_status === 'Pending')
    <span class="badge text-bg-warning" title="Waiting for QM approval">Pending</span>
@elseif ($record->approval_status === 'Rejected')
    <span class="badge bg-bs-danger text-white" title="{{ $record->approvalRequests->sortByDesc('id')->first()?->reason }}">Rejected</span>
@endif
