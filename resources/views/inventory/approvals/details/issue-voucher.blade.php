{{-- Issuance request: the voucher and every stock unit it sends out. --}}
<x-card title="Issue Voucher Details">
    <x-slot:actions>
        <a href="{{ route('inventory.transaction.stockposition.pdf', $record) }}" class="btn btn-secondary" target="_blank"><i class="fa-solid fa-file-pdf"></i> Delivery Challan</a>
    </x-slot:actions>
    <x-info-columns :columns="[
        ['Invoice No' => $record->iv_no, 'Date' => $record->date?->format('d M Y'), 'From Wing' => $record->fromUnit?->name],
        ['Issued By' => $record->creator ? $record->creator->full_name.' ('.$record->creator->name.')' : '',
         'Created At' => $record->created_at?->format('d M Y, h:i A'), 'Approval Status' => $record->approval_status],
    ]" />
    <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
        <thead><tr><th>Sl.</th><th>Item Code</th><th>Item Name</th><th>Category</th><th>Description</th><th>Serial No</th><th>Quantity</th><th>To Wing</th><th>Status</th><th>Actioned By</th></tr></thead>
        <tbody>
        @forelse ($record->items as $line)
            @php $item = $line->stock?->item; @endphp
            <tr>
                <td>{{ $loop->iteration }}</td><td>{{ $item?->code }}</td><td>{{ $item?->name }}</td><td>{{ $item?->category?->name }}</td>
                <td>{{ $item?->brand?->name }}, {{ $item?->productModel?->name }}</td><td>{{ $line->stock?->serial_no }}</td>
                <td>{{ $line->quantity }} {{ $item?->unit?->name }}</td><td>{{ $line->toUnit?->name }}</td><td>{{ $line->status }}</td>
                <td>{{ $line->actioner?->full_name }}{{ $line->actioned_at ? ' — '.$line->actioned_at->format('d M Y, h:i A') : '' }}</td>
            </tr>
        @empty
            <tr><td colspan="10">No items found</td></tr>
        @endforelse
        </tbody>
    </table>
</x-card>
