{{-- Purchase order request: same details as the PO page. --}}
<x-card title="Purchase Order Details">
    <x-slot:actions>
        <a href="{{ route('inventory.purchase.purchaseorders.pdf', $record) }}" class="btn btn-secondary" target="_blank"><i class="fa-solid fa-file-pdf"></i> PDF</a>
    </x-slot:actions>
    @include('inventory.purchase.orders._details', ['order' => $record])
</x-card>
